<?php

namespace App\Models;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;
use ReflectionClass;

trait HasParent
{
    public $hasParent = true;

    public static function bootHasParent()
    {
        // This adds support for using Parental with standalone Eloquent, outside a normal Laravel app.
        if (static::getEventDispatcher() === null) {
            static::setEventDispatcher(new Dispatcher());
        }

        static::creating(function ($model) {
            if ($model->parentHasHasChildrenTrait()) {
                $model->forceFill(
                    [$model->getInheritanceColumn() => $model->classToAlias(get_class($model))]
                );
            }
        });

        static::addGlobalScope('ParentalInheritance', function ($query) {
            $instance = $query->getModel();

            if ($instance->parentHasHasChildrenTrait()) {
                $query->where($instance->getTable().'.'.$instance->getInheritanceColumn(), $instance->classToAlias(get_class($instance)));
            }
        });
    }

    public function parentHasHasChildrenTrait(): bool
    {
        return $this->hasChildren ?? false;
    }

    /**
     * @throws \ReflectionException
     */
    public function getTable(): string
    {
        if (! isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this->getParentClass()))));
        }

        return $this->table;
    }

    /**
     * @throws \ReflectionException
     */
    public function getForeignKey(): string
    {
        return Str::snake(class_basename($this->getParentClass())).'_'.$this->primaryKey;
    }

    /**
     * @param $related
     * @throws \ReflectionException
     */
    public function joiningTable($related, null $instance = null): string
    {
        $relatedClassName = method_exists((new $related), 'getClassNameForRelationships')
            ? (new $related)->getClassNameForRelationships()
            : class_basename($related);

        $models = [
            Str::snake($relatedClassName),
            Str::snake($this->getClassNameForRelationships()),
        ];

        sort($models);

        return strtolower(implode('_', $models));
    }

    /**
     * @throws \ReflectionException
     */
    public function getClassNameForRelationships(): string
    {
        return class_basename($this->getParentClass());
    }

    /**
     * Get the class name for polymorphic relations.
     *
     * @throws \ReflectionException
     */
    public function getMorphClass(): string
    {
        if ($this->parentHasHasChildrenTrait()) {
            $parentClass = $this->getParentClass();

            return (new $parentClass)->getMorphClass();
        }

        return parent::getMorphClass();
    }

    /**
     * Get the class name for Parent Class.
     *
     * @throws \ReflectionException
     */
    protected function getParentClass(): string
    {
        static $parentClassName;

        return $parentClassName ?: $parentClassName = (new ReflectionClass($this))->getParentClass()->getName();
    }
}

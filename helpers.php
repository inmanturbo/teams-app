<?php

if (! function_exists('includeFileOrEmptyArray')) {
    /**
     * @param $file
     *
     * @return array
     */
    function includeFileOrEmptyArray($file): array
    {
        if (file_exists($file)) {
            return include $file;
        }

        return [];
    }
}

if (! function_exists('modelFromTable')) {
    function modelFromTable($table)
    {
        foreach( get_declared_classes() as $class ) {
            $class = new ReflectionClass($class);
            if( is_subclass_of( $class, 'Illuminate\Database\Eloquent\Model' ) && ! $class->isAbstract() ) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $class;
            }
        }

        return false;
    }
}
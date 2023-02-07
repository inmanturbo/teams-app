<?php

namespace App;

use Spatie\LaravelData\Data;

class ColumnData extends Data
{
    public function __construct(
        public string $name,
        public string $label,
        public string $class = '',
        public string $headerClass = '',
        public string $secondaryHeaderClass = '',
        public bool $hasView = false,
        public string $view = '',
        public string $footerClass = '',
        public bool $hasFooterView = false,
        public string $footerView = '',
        public bool $hasSecondaryHeaderView = false,
        public bool $hasSecondaryHeader = false,
        public string $secondaryHeaderView = '',
        public array $options = [],
        public $hasTotal = false,
        public $defaultValue = '',
        public $sortable = false,
        public $searchable = false,
        public $hasSecondaryHeaderSelect = false,
        public $hasHtml = false,
        public $html = '',
    ) {
    }

    public function html(string $html): self
    {
        $this->hasHtml = true;
        $this->html = $html;

        return $this;
    }

    public function secondaryHeaderSelect($options)
    {
        $this->hasSecondaryHeaderSelect = true;
        $this->options = $options;

        return $this;
    }

    public function searchable(): self
    {
        $this->searchable = true;

        return $this;
    }

    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }

    public function defaultValue($defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function withTotal(): self
    {
        $this->hasTotal = true;

        return $this;
    }

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function class($class)
    {
        $this->class = $class;

        return $this;
    }

    public function headerClass($class)
    {
        $this->headerClass = $class;

        return $this;
    }

    public function secondaryHeaderClass($class)
    {
        $this->secondaryHeaderClass = $class;

        return $this;
    }

    public function footerClass($class)
    {
        $this->footerClass = $class;

        return $this;
    }

    public function view(string $view): self
    {
        $this->hasView = true;
        $this->view = $view;

        return $this;
    }

    public function footerView(string $view): self
    {
        $this->hasFooterView = true;
        $this->footerView = $view;

        return $this;
    }

    public function secondaryHeaderView(string $view): self
    {
        $this->hasSecondaryHeaderView = true;
        $this->hasSecondaryHeader = true;
        $this->secondaryHeaderView = $view;

        return $this;
    }

    /**
     * methods below this comment block
     * will go into an interface
     *
     */

    /**
     * the following methods take in callbacks and
     * can be used to modify the data
     * they are only usable from within the livewire component
     * after the columnData objects have been unserialized
     */
    public function secondaryHeaderCallback($callback)
    {
        $this->hasSecondaryHeader = true;
        $this->secondaryHeaderCallback = $callback;

        return $this;
    }

    public function callback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    public function footerCallback($callback)
    {
        $this->hasFooter = true;
        $this->footerCallback = $callback;

        return $this;
    }

    /**
     * renderers that will be called from within the veiw
     */
    public function renderSecondaryHeader()
    {
        return isset($this->secondaryHeaderCallback) ? call_user_func($this->secondaryHeaderCallback) : '';
    }

    public function render($row, $rows)
    {
        return $this->hasView() ?
        view($this->view, [
            'row' => $row,
            'rows' => $rows,
            'column' => $this,
        ]) :
        $this->format($row, $rows);
    }

    public function renderFooter()
    {
        return isset($this->footerCallback) ? call_user_func($this->footerCallback) : '';
    }

    public function format($row, $rows)
    {
        if (isset($this->callback)) {
            return call_user_func($this->callback, $row, $rows, $this);
        }

        return isset($row->{$this->name}) ? $row->{$this->name} : $this->getDefaultValue();
    }

    /**
     * The following methods are getters that
     * will be called from within the view
     */
    public function isSearchable() : bool
    {
        return $this->searchable;
    }

    public function isSortable() : bool
    {
        return $this->sortable;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getHeaderClass()
    {
        return $this->headerClass;
    }

    public function getSecondaryHeaderClass()
    {
        return $this->secondaryHeaderClass;
    }

    public function getFooterClass()
    {
        return $this->footerClass;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getFooterView()
    {
        return $this->footerView;
    }

    public function getSecondaryHeaderView()
    {
        return $this->secondaryHeaderView;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    /**
     * methods below are checkers which return booleans
     *
     */
    public function hasHtml() : bool
    {
        return $this->hasHtml;
    }

    public function hasSecondaryHeader(): bool
    {
        return $this->hasSecondaryHeader;
    }

    public function hasView(): bool
    {
        return $this->hasView;
    }

    public function hasFooterView(): bool
    {
        return $this->hasFooterView;
    }

    public function hasSecondaryHeaderView(): bool
    {
        return $this->hasSecondaryHeaderView;
    }

    public function hasTotal(): bool
    {
        return $this->hasTotal;
    }

    public function hasSecondaryHeaderSelect(): bool
    {
        return $this->hasSecondaryHeaderSelect;
    }
}

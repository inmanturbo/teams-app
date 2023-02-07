<?php

namespace App;

use Spatie\LaravelData\Data;

class DatatableConfig extends Data
{
    public function __construct(
        public string $modelBaseName = '',
        public string $tableClass = '',
        public string $tBodyClass = '',
        public string $evenTrClass = '',
        public string $oddTrClass = '',
        public array $configurableAreas = [],
        public string $dateColumn = '',
        public bool $hasDateFilters = false,
        public int $perPage = 25,
        public array $perPageOptions = [25, 50, 100, 250, 500],
        public array $toolbarLeftEndItems = [],
        public array $dates = [],
        public array $additionalSelects = [],
    ) {
    }

    public function additionalSelects(array $additionalSelects): self
    {
        $this->additionalSelects = $additionalSelects;

        return $this;
    }

    public function dates(array $dates)
    {
        $this->dates = $dates;

        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function perPageOptions(array $perPageOptions): self
    {
        $this->perPageOptions = $perPageOptions;

        return $this;
    }

    public function withDateFilters($dateColumn): self
    {
        $this->dateColumn = $dateColumn;
        $this->hasDateFilters = true;

        return $this;
    }

    public function toolbarLeftEndItems(array $items, $view = 'livewire-tables.toolbar-left-end'): self
    {
        $this->toolBarLeftEnd($view);
        $this->toolbarLeftEndItems = $items;

        return $this;
    }

    public function getToolBarLeftEndItems(): array
    {
        return $this->toolbarLeftEndItems;
    }

    public function toolbarLeftStart($view): self
    {
        $this->configurableAreas['toolbar-left-start'] = $view;

        return $this;
    }

    public function toolbarLeftEnd($view = 'livewire-tables.toolbar-left-end'): self
    {
        $this->configurableAreas['toolbar-left-end'] = $view;

        return $this;
    }

    public function toolbarRightStart($view): self
    {
        $this->configurableAreas['toolbar-right-start'] = $view;

        return $this;
    }

    public function toolbarRightEnd($view): self
    {
        $this->configurableAreas['toolbar-right-end'] = $view;

        return $this;
    }

    public function evenClass($evenClass): self
    {
        $this->evenTrClass = $evenClass;

        return $this;
    }

    public function oddClass($oddClass): self
    {
        $this->oddTrClass = $oddClass;

        return $this;
    }

    public function tableClass($tableClass): self
    {
        $this->tableClass = $tableClass;

        return $this;
    }

    public function getTableClass(): string
    {
        return $this->tableClass;
    }

    public function tBodyClass($tBodyClass): self
    {
        $this->tBodyClass = $tBodyClass;

        return $this;
    }

    public function getTBodyClass(): string
    {
        return $this->tBodyClass;
    }

    public function getTrClass($index)
    {
        return $index % 2 === 0 ? $this->evenTrClass : $this->oddTrClass;
    }

    public function getConfigurableAreas(): array
    {
        return $this->configurableAreas;
    }

    public function getDateColumn(): string
    {
        return $this->dateColumn;
    }

    public function hasDateFilters(): bool
    {
        return $this->hasDateFilters;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getPerPageOptions(): array
    {
        return $this->perPageOptions;
    }

    public function getDates(): array
    {
        return array_keys($this->dates);
    }

    public function getDateFormat($date): string
    {
        return $this->dates[$date];
    }

    public function getAdditionalSelects(): array
    {
        return $this->additionalSelects;
    }
}

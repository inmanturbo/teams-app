<?php

use App\Http\Livewire\GeneralLedgerTable;
use App\Http\Livewire\LivewireTable;
use App\Models\GeneralLedger;

Route::get('/gl', function () {
    $tHeadLeftClass = 'bg-[#BCD6A7] text-[#0000FF] uppercase text-sm text-left whitespace-nowrap';
    $tHeadRightClass = 'bg-[#BCD6A7] text-[#0000FF] uppercase text-sm text-right whitespace-nowrap';
    $columnData = [];

    $standardColumns = [
        'year' => 'Year',
        'month' => 'Month',
        'Date' => 'Date',
        'dp' => 'DP',
        'BusAccName' => 'Bank Account',
        'Status' => 'Status',
        'Entry' => 'DB/CR',
        'Transaction' => 'Type',
        'CheckNo' => 'Check No',
        // 'BusName' => 'Payee',
        'JobName' => 'Job',
        'Reference' => 'Invoice',
        'Division' => 'Division',
        'AccName' => 'Account',
    ];

    foreach ($standardColumns as $key => $value) {
        $column = (new \App\ColumnData($key, $value))
            ->class('whitespace-nowrap text-xs')
            ->headerClass($tHeadLeftClass)
            ->secondaryHeaderClass('whitespace-nowrap justify-start')
            ->secondaryHeaderView('header-select')
            ->secondaryHeaderSelect(GeneralLedger::getCachedOptions($key))
            ->sortable()
            ->searchable()
            ->toArray();
        $columnData[$key] = $column;
    }
    $columnData['BusName'] = (new \App\ColumnData('BusName', 'Payee'))
        ->class('whitespace-nowrap text-xs')
        ->headerClass($tHeadLeftClass)
        ->secondaryHeaderClass('whitespace-nowrap justify-start')
        ->secondaryHeaderView('header-select')
        ->secondaryHeaderSelect(GeneralLedger::getCachedOptions('BusName'))
        ->view('payee')
        ->sortable()
        ->searchable()
        ->toArray();

    $columnData['DetailMemo'] = (new \App\ColumnData('DetailMemo', 'Memo'))
        ->class('whitespace-normal text-xs tracking-tighter')
        ->headerClass($tHeadLeftClass)
        ->secondaryHeaderClass('whitespace-nowrap justify-start')
        ->secondaryHeaderView('header-select')
        ->secondaryHeaderSelect(GeneralLedger::getCachedOptions('DetailMemo'))
        ->sortable()
        ->searchable()
        ->toArray();

    $columnData['Debit'] = (new \App\ColumnData('Debit', 'Debit'))
        ->class('whitespace-nowrap text-xs text-right text-red-500')
        ->headerClass($tHeadRightClass)
        ->secondaryHeaderClass('whitespace-nowrap text-xs text-right text-red-500')
        ->footerClass('whitespace-nowrap text-xs text-right text-red-500')
        ->withTotal()
        ->sortable()
        ->searchable()
        ->toArray();
    $columnData['Credit'] = (new \App\ColumnData('Credit', 'Credit'))
        ->class('whitespace-nowrap text-xs text-right text-blue-500')
        ->secondaryHeaderClass('whitespace-nowrap text-xs text-right text-blue-500')
        ->headerClass($tHeadRightClass)
        ->footerClass('whitespace-nowrap text-xs text-right text-blue-500')
        ->withTotal()
        ->sortable()
        ->searchable()
        ->toArray();

    $tableData = (new \App\DatatableConfig)
        ->toolbarLeftEndItems(['livewire-tables.export-all', 'livewire-tables.export-page', 'livewire-tables.print-page', 'livewire-tables.reset', 'livewire-tables.year-to-date'])
        ->perPage(25)
        ->perPageOptions([25, 50, 100, 500])
        ->withDateFilters('date')
        ->evenClass('bg-gray-100 border-gray-500 border-b border-t')
        ->oddClass('bg-white border-gray-500 border-b border-t')
        ->tableClass('w-full')
        ->tBodyClass('bg-white')
        ->dates(['Date' => 'm-d-Y'])
        ->toArray();

    return view('livewire-tables.table', [
        'columnData' => $columnData,
        'tableData' => $tableData,
        'dataset' => GeneralLedger::class,
        'modals' => [
            'gl-payee-modal' => [],
        ],
    ]);
})->middleware('auth:web');

Route::prefix('colorbox')->group(function () {
    Route::get('/', function () {
        return view('colorbox.index');
    });
    Route::get('/modal-demo', function () {
        return view('colorbox.modal-demo');
    });
});
<?php

use App\Http\Livewire\GeneralLedgerTable;
use App\Http\Livewire\LivewireTable;
use App\Models\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:web', 'charter.user'])->get('/id', function (Request $request) {
    dd(auth());
})->name('id');

Route::get('memberships/{membership}', function (\App\Models\Membership $membership) {
    return $membership->toJson();
});

// list all users as json
Route::get('users', function () {
    return \App\Models\User::all();
});

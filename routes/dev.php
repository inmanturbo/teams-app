<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::get('/db-config/{key?}', function ($key = null) {
    //get the config array for the default database connection
    return [
      'data' => $key ? [ $key => DB::getConfig($key) ] : DB::getConfig(),
    ];
});

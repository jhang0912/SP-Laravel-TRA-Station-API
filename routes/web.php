<?php

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

Route::middleware(['throttle:tra'])->prefix('v1/tra/stations')->group(function () {
    Route::get('/', 'App\Http\Controllers\TRAStationController@stations');
    Route::get('/{stationName}', 'App\Http\Controllers\TRAStationController@station');
    Route::get('/{stationName}/exits', 'App\Http\Controllers\TRAStationController@exits');
});

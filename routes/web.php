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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([])->prefix('v1/tra')->group(function () {
    Route::get('/stations', 'App\Http\Controllers\TraStationController@allStations');
    Route::get('/stations/{postCode}', 'App\Http\Controllers\TraStationController@districtStations');
    Route::post('/stations/{stationName}', 'App\Http\Controllers\TraStationController@station');

    Route::get('/stations/delRedis/{key}', 'App\Http\Controllers\Redis\RedisController@delete');
});

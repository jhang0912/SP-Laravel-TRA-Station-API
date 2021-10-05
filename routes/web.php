<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;


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
    Route::get('/stations', 'App\Http\Controllers\TRAStationController@getAllTRAStations');
    Route::get('/stations/{id}', 'App\Http\Controllers\TRAStationController@getTRAStation');

    // Route::get('/stations/delRedis/{key}', 'App\Http\Controllers\AdminController@deleteRedis');
});

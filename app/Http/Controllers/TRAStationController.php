<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admins\RedisController;
use App\Http\Controllers\Interfaces\RailStation;
use App\Http\Services\TraStationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TraStationController extends Controller implements RailStation
{
    public function __construct()
    {
        if (Redis::get('TraStations') == null) {
            $traStations = new TraStationService();
            RedisController::create('TraStations', $traStations->stations());
        }
    }

    public function allStations(Request $request)
    {
        return response(Redis::get('TraStations'), 200);
    }

    public function districtStations(Request $request)
    {
        return response();
    }

    public function station(Request $request)
    {
        return response(['postCode' => $request->post], 200);
    }
}

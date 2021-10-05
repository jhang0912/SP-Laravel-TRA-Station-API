<?php

namespace App\Http\Controllers;

use App\Http\Handle\TraPostCode;
use App\Http\Controllers\Redis\RedisController;
use App\Http\Controllers\Interfaces\RailStation;
use App\Http\Services\TraStationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TraStationController extends Controller implements RailStation
{
    public function __construct()
    {
        if (Redis::get('tra_all_stations') == null) {
            $traStations = new TraStationService();
            Redis::set('tra_all_stations', json_encode($traStations->stations()));
        }
    }

    public function allStations(Request $request)
    {
        return response(Redis::get('tra_all_stations'), 200);
    }

    public function districtStations(Request $request)
    {
        $postCode = $request->postCode;
        $traStations = new TraPostCode($postCode);

        return response($traStations->handle(),200);
    }

    public function station(Request $request)
    {
        return response(['postCode' => $request->post], 200);
    }
}

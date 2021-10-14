<?php

namespace App\Http\Controllers;

use App\Http\Handle\TraPostCode;
use App\Http\Handle\TraStationName;
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
            RedisController::create('tra_all_stations', json_encode($traStations->stations()));
        }
    }


    public function allStations(Request $request)
    {
        return response(['Stations' => json_decode(Redis::get('tra_all_stations'))], 200);
    }


    public function districtStations(Request $request)
    {
        $postCode = $request->postCode;

        if (Redis::get('tra_' . $postCode . '_stations') == null) {
            $traPostCode = new TraPostCode($postCode);

            $traStations = $traPostCode->handle();

            if (empty($traStations)) {
                return response(['message' => '非常抱歉，此區域內無台鐵車站資料'], 403);
            }

            RedisController::create('tra_' . $postCode . '_stations', json_encode($traStations));
        }

        return response(['Stations' => json_decode(Redis::get('tra_' . $postCode . '_stations'))], 200);
    }


    public function station(Request $request)
    {
        $stationName = $request->stationName;

        if (Redis::get('tra_' . $stationName . '_station') == null) {
            $traStationName = new TraStationName($stationName);

            $traStation = $traStationName->handle();

            if (empty($traStation)) {
                return response(['message' => '非常抱歉，無此台鐵車站資料'], 403);
            }

            RedisController::create('tra_' . $stationName . '_station', json_encode($traStation));
        }
        return response(['Station' => json_decode(Redis::get('tra_' . $stationName . '_station'))], 200);
    }
}

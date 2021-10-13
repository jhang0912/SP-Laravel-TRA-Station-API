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
            RedisController::create('tra_all_stations', json_encode($traStations->stations()));
        }
    }

    public function allStations(Request $request)
    {
        return response(Redis::get('tra_all_stations'), 200)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function districtStations(Request $request)
    {
        $postCode = $request->postCode;

        if (Redis::get('tra_' . $postCode . '_stations') == null) {
            $traPostCode = new TraPostCode($postCode);

            $traStations = $traPostCode->handle();

            if (empty($traStations)) {
                return response(['message' => '非常抱歉，此區域內無台鐵車站資料'], 200);
            }

            RedisController::create('tra_' . $postCode . '_stations', json_encode($traStations));
        }

        return response(Redis::get('tra_' . $postCode . '_stations'), 200)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function station(Request $request)
    {
        return response(['postCode' => $request->post], 200);
    }
}

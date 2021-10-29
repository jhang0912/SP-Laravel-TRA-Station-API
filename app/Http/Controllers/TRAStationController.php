<?php

namespace App\Http\Controllers;

use App\Http\Handle\County;
use App\Http\Handle\PostCode;
use App\Http\Handle\StationName;
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
            $Stations = $traStations->stations();
            if ($Stations != null) {
                RedisController::create('tra_all_stations', json_encode($Stations));
            }
        }
    }


    public function stations(Request $request)
    {
        $Stations = json_decode(Redis::get('tra_all_stations'));
        if (empty($Stations)) {
            return response(['message' => '非常抱歉，系統發生異常錯誤，請聯絡開發人員'], 501);
        }
        return response(['Stations' => json_decode(Redis::get('tra_all_stations'))], 200);
    }


    public function station(Request $request)
    {
        $stationName = $request->stationName;
        if (Redis::get('tra_' . $stationName . '_station') == null) {
            $traStationName = new StationName($stationName);
            $traStation = $traStationName->handle();
            if (empty($traStation)) {
                return response(['message' => '非常抱歉，無此台鐵車站資料'], 403);
            }
            RedisController::create('tra_' . $stationName . '_station', json_encode($traStation));
        }
        return response(['Station' => json_decode(Redis::get('tra_' . $stationName . '_station'))], 200);
    }


    public function county(Request $request)
    {
        $county = $request->county;
        if (Redis::get('tra_' . $county . '_stations') == null) {
            $traCounty = new County($county);
            $traStations = $traCounty->handle();
            if (empty($traStations)) {
                return response(['message' => '非常抱歉，此縣市內無台鐵車站資料'], 403);
            }
            RedisController::create('tra_' . $county . '_stations', json_encode($traStations));
        }
        return response(['Stations' => json_decode(Redis::get('tra_' . $county . '_stations'))], 200);
    }


    public function postCode(Request $request)
    {
        $postCode = $request->postCode;
        if (Redis::get('tra_' . $postCode . '_stations') == null) {
            $traPostCode = new PostCode($postCode);
            $traStations = $traPostCode->handle();
            if (empty($traStations)) {
                return response(['message' => '非常抱歉，此區域內無台鐵車站資料'], 403);
            }
            RedisController::create('tra_' . $postCode . '_stations', json_encode($traStations));
        }
        return response(['Stations' => json_decode(Redis::get('tra_' . $postCode . '_stations'))], 200);
    }
}

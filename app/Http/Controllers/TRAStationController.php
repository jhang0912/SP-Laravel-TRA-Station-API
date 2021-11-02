<?php

namespace App\Http\Controllers;

use App\Http\Handle\Address;
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
        $address = $request->address;
        $postCode = $request->postCode;
        $Stations = json_decode(Redis::get('tra_all_stations'));
        if (empty($Stations)) {
            return response(['message' => '非常抱歉，系統發生異常錯誤，請聯絡開發人員'], 501);
        }
        if (!empty($address)) {
            $traCounty = new Address($address);
            $traStations = $traCounty->handle();
            if (empty($traStations)) {
                return response(['message' => '非常抱歉，查無資料'], 403);
            }
            return response(['Stations' => $traStations], 200);
        }
        if (!empty($postCode)) {
            $traPostCode = new PostCode($postCode);
            $traStations = $traPostCode->handle();
            if (empty($traStations)) {
                return response(['message' => '非常抱歉，查無資料'], 403);
            }
            return response(['Stations' => $traStations], 200);
        }
        return response(['Stations' => $Stations], 200);
    }


    public function station(Request $request)
    {
        $stationName = $request->stationName;
        if (Redis::get('tra_' . $stationName . '_station') == null) {
            $traStationName = new StationName($stationName);
            $traStation = $traStationName->handle();
            if ($traStationName->status == 'error') {
                return response(['message' => '非常抱歉，系統發生異常錯誤，請聯絡開發人員'], 501);
            }
            if (empty($traStation)) {
                return response(['message' => '非常抱歉，無此台鐵車站資料'], 403);
            }
            RedisController::create('tra_' . $stationName . '_station', json_encode($traStation));
        }
        return response(['Station' => json_decode(Redis::get('tra_' . $stationName . '_station'))], 200);
    }

    /* Nested Resource */

    public function exits(Request $request)
    {
        $stationName = $request->stationName;

        return response($stationName, 200);
    }
}

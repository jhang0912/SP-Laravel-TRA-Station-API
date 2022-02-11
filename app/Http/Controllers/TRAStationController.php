<?php

namespace App\Http\Controllers;

use App\Http\Handle\Address;
use App\Http\Handle\PostCode;
use App\Http\Handle\StationExit;
use App\Http\Handle\StationName;
use App\Http\Controllers\Redis\RedisController;
use App\Http\Controllers\Interfaces\RailStation;
use App\Http\Services\TRAStationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TraStationController extends Controller implements RailStation
{
    public function __construct()
    {
        if (Redis::get('tra_all_stations') == null) {
            $TraStationService = new TRAStationService('Stations');
            $stations = $TraStationService->handle('https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/Station?$format=JSON');
            if ($stations != null) {
                RedisController::create('tra_all_stations', json_encode($stations));
            }
        }
        if (Redis::get('tra_all_exits') == null) {
            $TraStationService = new TRAStationService('StationExits');
            $stationExits = $TraStationService->handle('https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/StationExit?$format=JSON');
            if ($stationExits != null) {
                RedisController::create('tra_all_exits', json_encode($stationExits));
            }
        }
    }


    public function stations(Request $request)
    {
        $address = $request->address;
        $postCode = $request->postCode;
        $Stations = json_decode(Redis::get('tra_all_stations'));
        if (empty($Stations)) {
            return response(['Message' => '失敗，系統發生異常錯誤，請聯絡開發人員', 'Time' => now()], 501);
        }
        if (!empty($address)) {
            $Address = new Address($address);
            $traStations = $Address->handle();
            if (empty($traStations)) {
                return response(['Message' => '失敗，查無資料', 'Time' => now()], 403);
            }
            return response(['Stations' => $traStations], 200);
        }
        if (!empty($postCode)) {
            $PostCode = new PostCode($postCode);
            $traStations = $PostCode->handle();
            if (empty($traStations)) {
                return response(['Message' => '失敗，查無資料', 'Time' => now()], 403);
            }
            return response(['Message' => '成功', 'Time' => now(), 'Stations' => $traStations], 200);
        }
        return response(['Message' => '成功', 'Time' => now(), 'Stations' => $Stations], 200);
    }


    public function station(Request $request)
    {
        $stationName = $request->stationName;
        if (Redis::get('tra_' . $stationName . '_station') == null) {
            $StationName = new StationName($stationName);
            $traStation = $StationName->handle();
            if ($StationName->status == 'error') {
                return response(['Message' => '失敗，系統發生異常錯誤，請聯絡開發人員', 'Time' => now()], 501);
            }
            if (empty($traStation)) {
                return response(['Message' => '失敗，無此台鐵車站資料', 'Time' => now()], 403);
            }
            RedisController::create('tra_' . $stationName . '_station', json_encode($traStation));
        }
        return response(['Message' => '成功', 'Time' => now(), 'Station' => json_decode(Redis::get('tra_' . $stationName . '_station'))], 200);
    }

    /* Nested Resource */

    public function exits(Request $request)
    {
        $stationName = $request->stationName;
        if (Redis::get('tra_' . $stationName . '_exits') == null) {
            $StationExit = new StationExit($stationName);
            $stationExits = $StationExit->handle();
            if ($StationExit->status == 'error') {
                return response(['Message' => '失敗，系統發生異常錯誤，請聯絡開發人員', 'Time' => now()], 501);
            }
            if (empty($stationExits)) {
                return response(['Message' => '失敗，無此台鐵車站資料', 'Time' => now()], 403);
            }
            RedisController::create('tra_' . $stationName . '_exits', json_encode($stationExits));
        }
        return response(['Message' => '成功', 'Time' => now(), 'StationExits' => json_decode(Redis::get('tra_' . $stationName . '_exits'))], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Services\Signature\TRASignature;
use Illuminate\Http\Request;
use App\Http\Services\TRAStationService;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Admins\RedisController;


class TraStationController extends Controller
{
    public function __construct()
    {
        if (Redis::get('TraStations') == null) {
            $traStations = new TraStationService();
            RedisController::create('TraStations', $traStations->getTraStation());
        }
    }

    public function allStations(Request $request)
    {
        return response(Redis::get('TraStations'), 200);
    }

    public function station(Request $request)
    {
        return response(['id' => $request->id], 200);
    }
}

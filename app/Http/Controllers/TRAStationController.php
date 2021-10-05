<?php

namespace App\Http\Controllers;

use App\Http\Services\Signature\TRASignature;
use Illuminate\Http\Request;
use App\Http\Services\TRAStationService;
use Illuminate\Support\Facades\Redis;


class TRAStationController extends Controller
{
    public function __construct()
    {
        if (Redis::get('TRAStations') == null) {
            $TRAStations = new TRAStationService();
            Redis::set('TRAStations', $TRAStations->getTRAStation());
        }
    }

    public function getAllTRAStations(Request $request)
    {
        // $TRAStation = new TRAStationService();

        return response(Redis::get('TRAStations'), 200);
    }

    public function getTRAStation(Request $request)
    {
        return response(['id' => $request->id], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Services\Signature\TRASignature;
use Illuminate\Http\Request;
use App\Http\Services\TRAStationService;

class TRAStationController extends Controller
{
    public function getAllTRAStation(Request $request)
    {
        $TRAStation = new TRAStationService();

        return response($TRAStation->getTRAStation(), 200);

        // return response(['message' => 'success'], 200);
    }

    public function getTRAStation(Request $request)
    {
        return response(['id' => $request->id], 200);
    }
}

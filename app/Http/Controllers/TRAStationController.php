<?php

namespace App\Http\Controllers;

use App\Http\Services\Signature\TRASignature;
use Illuminate\Http\Request;
use App\Http\Services\TRAStationService;

class TRAStationController extends Controller
{
    public function getTRAStation(Request $request)
    {
        $TRAStation = new TRAStationService();

        return response($TRAStation->getTRAStation(), 200);

        // return response(['message' => 'success'], 200);
    }
}

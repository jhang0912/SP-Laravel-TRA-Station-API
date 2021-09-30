<?php

namespace App\Http\Controllers;

use App\Http\Services\Signature\TRASignature;
use Illuminate\Http\Request;
use App\Http\Services\TRAStationService;

class TRAStationController extends Controller
{
    public function getTRAStation()
    {
        $TRAStation = new TRAStationService();

        return $TRAStation->getTRAStation();
    }
}

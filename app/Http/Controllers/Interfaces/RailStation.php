<?php

namespace App\Http\Controllers\Interfaces;

use Illuminate\Http\Request;


interface RailStation
{
    public function allStations(Request $request);

    public function districtStations(Request $request);

    public function station(Request $request);
}

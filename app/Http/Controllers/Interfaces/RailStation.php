<?php

namespace App\Http\Controllers\Interfaces;

use Illuminate\Http\Request;


interface RailStation
{
    public function stations(Request $request);

    public function station(Request $request);
}

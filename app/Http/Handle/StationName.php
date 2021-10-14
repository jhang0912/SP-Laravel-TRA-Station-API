<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;

class StationName
{
    private $stationName;
    private $station = array();

    public function __construct($stationName)
    {
        $this->stationName = $stationName;
    }

    public function handle()
    {
        $traStations = json_decode(Redis::get('tra_all_stations'));
        foreach ($traStations as $traStation) {
            if ($traStation->StationName->En == $this->stationName) {
                $this->station[] = $traStation;
            }
        }
        return $this->station;
    }
}

<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;

class TraStationName
{
    private $statisonName;
    private $station = array();

    public function __construct($statisonName)
    {
        $this->statisonName = $statisonName;
    }

    public function handle()
    {
        $traStations = json_decode(Redis::get('tra_all_stations'));

        foreach ($traStations as $traStation) {
            if ($traStation->StationName->Zh_tw == $this->statisonName) {
                $this->station[] = $traStation;
            }
        }

        return $this->station;
    }
}

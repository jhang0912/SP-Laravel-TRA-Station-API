<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;

class County
{
    private $county;
    private $stations = array();

    public function __construct($county)
    {
        $this->county = $county;
    }

    public function handle()
    {
        $traStations = json_decode(Redis::get('tra_all_stations'));
        foreach ($traStations as $traStation) {
            if (strpos($traStation->StationAddress, $this->county)) {
                $this->stations[] = $traStation;
            }
        }
        return $this->stations;
    }
}

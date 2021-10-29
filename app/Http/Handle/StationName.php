<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class StationName
{
    public $status;
    private $stationName;
    private $station = array();

    public function __construct($stationName)
    {
        $this->stationName = $stationName;
    }

    public function handle()
    {
        try {
            $traStations = json_decode(Redis::get('tra_all_stations'));
            foreach ($traStations as $traStation) {
                if ($traStation->StationName->En == $this->stationName) {
                    $this->station[] = $traStation;
                }
            }
            return $this->station;
        } catch (\Throwable $th) {
            $this->status = 'error';
            Log::channel('Handle')->error(['source' => 'StationName', 'message' => $th->getMessage()]);
        }
    }
}

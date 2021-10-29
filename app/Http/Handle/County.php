<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class County
{
    public $status;
    private $county;
    private $stations = array();

    public function __construct($county)
    {
        $this->county = $county;
    }

    public function handle()
    {
        try {
            $traStations = json_decode(Redis::get('tra_all_stations'));
            foreach ($traStations as $traStation) {
                if (strpos($traStation->StationAddress, $this->county)) {
                    $this->stations[] = $traStation;
                }
            }
            return $this->stations;
        } catch (\Throwable $th) {
            $this->status = 'error';
            Log::channel('Handle')->error(['source' => 'County', 'message' => $th->getMessage()]);
        }
    }
}

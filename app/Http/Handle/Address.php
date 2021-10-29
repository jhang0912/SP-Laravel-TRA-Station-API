<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class Address
{
    public $status;
    private $address;
    private $stations = array();

    public function __construct($address)
    {
        $this->address = $address;
    }

    public function handle()
    {
        try {
            $traStations = json_decode(Redis::get('tra_all_stations'));
            foreach ($traStations as $traStation) {
                if (strpos($traStation->StationAddress, $this->address)) {
                    $this->stations[] = $traStation;
                }
            }
            return $this->stations;
        } catch (\Throwable $th) {
            $this->status = 'error';
            Log::channel('Handle')->error(['source' => 'Address', 'line' => $th->getLine(), 'message' => $th->getMessage()]);
        }
    }
}

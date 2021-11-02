<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class StationExit
{
    public $status;
    private $stationName;
    private $stationExits;

    public function __construct($stationName)
    {
        $this->stationName = $stationName;
    }

    public function handle()
    {
        try {
            $stationExits = json_decode(Redis::get('tra_all_exits'));
            foreach ($stationExits as $stationExit) {
                if ($stationExit->StationName->En == $this->stationName) {
                    $this->stationExits = $stationExit;
                }
            }
            return $this->stationExits;
        } catch (\Throwable $th) {
            $this->status = 'error';
            Log::channel('Handle')->error(['source' => 'StationExit', 'line' => $th->getLine(), 'message' => $th->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class PostCode
{
    public $status;
    private $postCode;
    private $stations = array();

    public function __construct($postCode)
    {
        $this->postCode = $postCode;
    }

    public function handle()
    {
        try {
            $traStations = json_decode(Redis::get('tra_all_stations'));
            foreach ($traStations as $traStation) {
                $postCode = mb_substr($traStation->StationAddress, 0, 3, 'utf8');
                if ($postCode == $this->postCode) {
                    $this->stations[] = $traStation;
                }
            }
            return $this->stations;
        } catch (\Throwable $th) {
            $this->status = 'error';
            Log::channel('Handle')->error(['source' => 'PostCode', 'line' => $th->getLine(), 'message' => $th->getMessage()]);
        }
    }
}

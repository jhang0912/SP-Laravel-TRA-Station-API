<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;


class TraPostCode
{
    private $postCode;
    private $stations = array();

    public function __construct($postCode)
    {
        $this->postCode = $postCode;
    }

    public function handle()
    {
        $traStations = json_decode(Redis::get('tra_all_stations'));

        foreach ($traStations as $traStation) {
            $postCode = mb_substr($traStation->StationAddress, 0, 3, 'utf8');

            if ($postCode == $this->postCode) {
                $this->stations[] = $traStation;
            }
        }

        return $this->stations;
    }
}

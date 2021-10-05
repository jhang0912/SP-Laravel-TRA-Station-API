<?php

namespace App\Http\Handle;

use Illuminate\Support\Facades\Redis;

class TraPostCode
{
    private $postCode;

    public function __construct($postCode)
    {
        $this->postCode = $postCode;
    }

    public function handle()
    {
        $traAllStations = Redis::get('tra_all_stations');

        return $traAllStations;
    }
}

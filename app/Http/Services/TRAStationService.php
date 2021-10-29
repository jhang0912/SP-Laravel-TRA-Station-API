<?php

namespace App\Http\Services;

use App\Http\Services\Signature\TraSignature;
use App\Http\Handle\ObjectToArray;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TraStationService
{
    private $authorization;

    public function __construct()
    {
        $this->authorization = new TraSignature();
    }

    public function stations()
    {
        try {
            $response = Http::accept('application/json')
                ->withHeaders([
                    'x-' => $this->authorization->date(),
                    'Authorization' => 'hmac username="' . env('TRA_API_ID') . '", algorithm="hmac-sha1", headers="x-date", signature="' . $this->authorization->Signature() . '"'
                ])
                ->get('https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/Station?$format=JSON');
            $response = json_decode($response);
            if (!empty($response->message)) {
                Log::channel('TRAStationService')->error('error', ['message' => $response->message]);
            } else {
                return ObjectToArray::handle($response);
            }
        } catch (\Throwable $th) {
            Log::channel('TRAStationService')->error('error', ['message' => $th->getMessage()]);
        }
    }
}

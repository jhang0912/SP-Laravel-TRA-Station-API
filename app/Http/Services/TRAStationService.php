<?php

namespace App\Http\Services;

use App\Http\Services\Signature\TraSignature;
use App\Http\Handle\ObjectToArray;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TraStationService
{
    private $authorization;
    private $resource;

    public function __construct(string $resource)
    {
        $this->authorization = new TraSignature();
        $this->resource = $resource;
    }

    public function handle(string $url)
    {
        try {
            $response = Http::accept('application/json')
                ->withHeaders([
                    'x-date' => $this->authorization->date(),
                    'Authorization' => 'hmac username="' . env('TRA_API_ID') . '", algorithm="hmac-sha1", headers="x-date", signature="' . $this->authorization->Signature() . '"'
                ])
                ->get($url);
            $response = json_decode($response);
            if (!empty($response->message)) {
                Log::channel('Service')->error('error', ['source' => 'TRAStationService', 'message' => $response->message]);
            } else {
                return ObjectToArray::handle($this->resource, $response);
            }
        } catch (\Throwable $th) {
            Log::channel('Service')->error('error', ['source' => 'TRAStationService', 'message' => $th->getMessage()]);
        }
    }
}

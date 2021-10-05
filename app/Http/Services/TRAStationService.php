<?php

namespace App\Http\Services;

use App\Http\Services\Signature\TraSignature;

class TraStationService
{
    private $authorization;

    public function __construct()
    {
        $this->authorization = new TraSignature();
    }

    public function stations()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/Station?$format=JSON',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-date: ' . $this->authorization->Date(),
                'Authorization: hmac username="' . env('TRA_API_ID') . '", algorithm="hmac-sha1", headers="x-date", signature="' . $this->authorization->Signature() . '"',
                'Accept-Encoding: gzip, deflate'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}

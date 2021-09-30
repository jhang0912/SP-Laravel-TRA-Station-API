<?php

namespace App\Http\Services;

use App\Http\Services\Signature\TRASignature;

class TRAStationService
{
    private $authorization;

    public function __construct()
    {
        $this->authorization = new TRASignature();
    }

    public function getTRAStation()
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
                'x-date: ' . $this->authorization->getXdate(),
                'Authorization: hmac username="'.$this->authorization->getAppId().'", algorithm="hmac-sha1", headers="x-date", signature="'.$this->authorization->getSignature().'"'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}

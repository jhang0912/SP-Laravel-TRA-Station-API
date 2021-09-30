<?php

namespace App\Http\Services\Signature;

class TRASignature
{
    private $xDate;
    private $signature;

    public function __construct()
    {
        $this->xDate = gmdate('D, d M Y H:i:s') . ' GMT';
        $this->signature = base64_encode(hash_hmac("sha1", "x-date: $this->xDate", env('TRA_API_KEY'), true));
    }

    public function getXdate()
    {
        return $this->xDate;
    }

    public function getSignature()
    {
        return $this->signature;
    }
}

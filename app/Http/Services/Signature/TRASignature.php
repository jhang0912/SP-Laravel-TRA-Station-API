<?php

namespace App\Http\Services\Signature;

class TRASignature
{
    private $date;
    private $signature;

    public function __construct()
    {
        $this->date = gmdate('D, d M Y H:i:s') . ' GMT';
        $this->signature = base64_encode(hash_hmac("sha1", "x-date: $this->date", env('TRA_API_KEY'), true));
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSignature()
    {
        return $this->signature;
    }
}

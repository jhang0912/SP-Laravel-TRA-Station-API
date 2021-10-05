<?php

namespace App\Http\Services\Signature;

class TraSignature
{
    private $date;
    private $signature;

    public function __construct()
    {
        $this->date = gmdate('D, d M Y H:i:s') . ' GMT';
        $this->signature = base64_encode(hash_hmac("sha1", "x-date: $this->date", env('TRA_API_KEY'), true));
    }

    public function Date()
    {
        return $this->date;
    }

    public function Signature()
    {
        return $this->signature;
    }
}

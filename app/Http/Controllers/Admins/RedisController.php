<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class RedisController extends Controller
{
    static function create(string $key, $value)
    {
        Redis::set($key,$value);
    }
    static function delete(Request $request)
    {
        Redis::del($request->key);

        return response(Redis::get('TraStations'),200);
    }
}

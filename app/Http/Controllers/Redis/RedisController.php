<?php

namespace App\Http\Controllers\Redis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class RedisController extends Controller
{
    static function create(string $key, $value)
    {
        Redis::setex($key, 14400, $value);
    }
    static function delete(Request $request)
    {
        Redis::del($request->key);

        return response(Redis::get($request->key), 200);
    }
}

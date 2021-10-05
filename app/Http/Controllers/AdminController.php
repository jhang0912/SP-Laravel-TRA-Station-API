<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class AdminController extends Controller
{
    static function deleteRedis(Request $request)
    {
        Redis::del($request->key);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureDateIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        $serverDate = gmdate('D, d M Y H:i') . ' GMT';

        if ($request->hasHeader('x-date')) {
            $clientDate = $request->header('x-date');
        } else {
            return response(['Message' => '無法驗證 HMAC 簽章，HMAC 驗證需要有效日期或 x-date 標頭', 'Time' => now()], 401);
        }

        if ($serverDate !== $clientDate) {
            return response(['Message' => 'HMAC 簽章未通過驗證', 'Time' => now()], 403);
        }

        return $next($request);
    }
}

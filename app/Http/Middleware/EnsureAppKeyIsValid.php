<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAppKeyIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $appKey = 'EE76-CF71-C7A495-8D8F-91BF';

    public function handle(Request $request, Closure $next)
    {
        $serverDate = gmdate('D, d M Y H:i') . ' GMT';

        if ($request->hasHeader('Authorization')) {
            $clientSignature = $request->header('Authorization');
        } else {
            return response(['message' => '請求未授權'], 401);
        }

        $serverSignature = "signature='" . base64_encode(hash_hmac('sha1', $serverDate, $this->appKey, true)) . "'";

        if ($clientSignature !== $serverSignature) {
            return response(['message' => 'HMAC 簽章未通過驗證'], 403);
        }

        return $next($request);
    }
}

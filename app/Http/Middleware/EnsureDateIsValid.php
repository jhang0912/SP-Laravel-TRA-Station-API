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
            return response(['message' => 'HMAC signature cannot be verified, a valid date or x-date header is required for HMAC Authentication'], 401);
        }

        if ($serverDate !== $clientDate) {
            return response(['message' => 'HMAC signature does not match'], 403);
        }

        return $next($request);
    }
}

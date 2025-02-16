<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustProxies
{

    protected $proxies = '*';
    protected $headers = 
    \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
    \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
    \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
    \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}

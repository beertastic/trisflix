<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddresses = explode(';', config('access.whitelist'));

        foreach ($ipAddresses as $ip) {
            if (strpos($request->ip(), $ip) === 0) {
                return $next($request);
            }
        }
        return redirect('/');
    }


}

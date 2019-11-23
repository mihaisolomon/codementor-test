<?php

namespace App\Http\Middleware;

use Closure;

class HeadersLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //\Log::info(json_encode($request->header()));

        return $next($request);
    }
}

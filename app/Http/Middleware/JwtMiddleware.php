<?php

namespace App\Http\Middleware;

use App\Services\JwtServiceInterface;
use Closure;

class JwtMiddleware
{

    protected $jwtService;

    public function __construct(JwtServiceInterface $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $this->jwtService->decode($request);

        if (!isset($response['user'])) {
            return response()->json([
                'error' => $response['message']
            ], $response['code']);
        }

        $request->auth = $response['user'];
        
        return $next($request);
    }
}

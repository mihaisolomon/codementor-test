<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-29
 * Time: 11:38
 */

namespace App\Http\Middleware;

use Closure;

class JWTAuthenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $this->authenticate($request);

        if(isset($response['success']) && !$response['success']) {
            return response()->json($response, 401);
        }

        return $next($request);
    }
}

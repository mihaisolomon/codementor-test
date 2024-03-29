<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-29
 * Time: 11:36
 */

namespace App\Http\Middleware;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class BaseMiddleware
{
    /**
     * The JWT Authenticator.
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param  \Tymon\JWTAuth\JWTAuth  $auth
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Check the request for the presence of a token.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return array
     */
    public function checkForToken(Request $request)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {

            return ['message' => 'Token not provided', 'success' => false];

            //throw new UnauthorizedHttpException('jwt-auth', 'Token not provided');
        }
    }

    /**
     * Attempt to authenticate a user via the token in the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return array
     */
    public function authenticate(Request $request)
    {
        $this->checkForToken($request);

        try {
            if (! $this->auth->parseToken()->authenticate()) {
                //throw new UnauthorizedHttpException('jwt-auth', 'User not found');
                return ['message' => 'User not found', 'success' => false];

            }
        } catch (JWTException $e) {

            return ['message' => $e->getMessage(), 'success' => false];

            //throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }
    }

    /**
     * Set the authentication header.
     *
     * @param  \Illuminate\Http\Response|\Illuminate\Http\JsonResponse  $response
     * @param  string|null  $token
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function setAuthenticationHeader($response, $token = null)
    {
        $token = $token ?: $this->auth->refresh();
        $response->headers->set('Authorization', 'Bearer '.$token);

        return $response;
    }
}

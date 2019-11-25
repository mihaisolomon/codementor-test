<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\JWT\JwtServiceInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    protected $JWTAuth;

    protected $jwtService;
    /**
     * AuthController constructor.
     * @param JWTAuth $JWTAuth
     * @param JwtServiceInterface $jwtService
     */
    public function __construct(JWTAuth $JWTAuth, JwtServiceInterface $jwtService)
    {
        $this->JWTAuth = $JWTAuth;

        $this->jwtService = $jwtService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);

        try {
            if (!$token = $this->JWTAuth->attempt($credentials)) {
                return response()->json(['user_not_found'], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }

        $this->JWTAuth->setToken($token);

        $tkn = $this->jwtService->refreshToken($this->jwtService->getUserInfoByToken($token)['user']);

        return response()->json(['jwt' => $token, 'refresh_token' => $tkn], 200);
    }

    /**
     * Logout JWT
     * @param Request $request
     * @return array
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function logout(Request $request)
    {
        $this->JWTAuth->parseToken()->invalidate();
        return response()->json(['message' => 'token removed'], 204);
    }

    public function refresh(Request $request)
    {
        $this->validate($request, ['refresh_token' => 'required']);

        $response = $this->jwtService->getRefreshToken($request->get('refresh_token'));

        if(isset($request['user'])) {
            return response()->json([$request['message']], $response['code']);
        }

        return response()->json(['jwt' => $response['token']]);
    }
}

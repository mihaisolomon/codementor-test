<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    protected $JWTAuth;

    /**
     * AuthController constructor.
     * @param JWTAuth $JWTAuth
     */
    public function __construct(JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
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

        return response()->json(['jwt' => $token, 'refresh_token' => $token], 200);
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
        $this->validate($request, ['token' => 'required']);

        $this->JWTAuth->setToken($request->get('token'));

        try {
            $token = $this->JWTAuth->refresh();

            return response()->json(['jwt' => $token], 200);

        } catch (TokenBlacklistedException $tokenBlacklistedException) {
            return response()->json(['token_blacklisted'], 401);
        }

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 15:40
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Services\Gravatar;
use App\Services\JWT\JwtServiceInterface;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    protected $JWTAuth;

    protected $jwtService;

    public function __construct(JWTAuth $JWTAuth, JwtServiceInterface $jwtService)
    {
        $this->JWTAuth = $JWTAuth;

        $this->jwtService = $jwtService;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|unique:users,email|max:255',
            'name' => 'required|string|max:255',
            'password'=> 'required'
        ]);

        $token = $this->jwtService->createUser($request);

        return response()->json(['jwt' => $token, 'refresh_token' => $token], 201);
    }
}

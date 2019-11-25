<?php


namespace App\Services\JWT;

use App\User;
use Illuminate\Http\Request;

interface JwtServiceInterface
{
    public function createUser(Request $request);

    public function decode(Request $request);

    public function refreshToken(User $user);

    public function getUserInfoByToken($token);

    public function getRefreshToken($token);
}

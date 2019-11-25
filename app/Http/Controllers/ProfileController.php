<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 22:44
 */

namespace App\Http\Controllers;

use App\Services\JWT\JwtServiceInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $jwtService;

    public function __construct(JwtServiceInterface $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function me(Request $request)
    {
        $user = $request->auth;

        return $user;
    }

    public function logout(Request $request)
    {
        return response('', 204);
    }
}

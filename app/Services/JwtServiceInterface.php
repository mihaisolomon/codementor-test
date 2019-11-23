<?php


namespace App\Services;

use Illuminate\Http\Request;

interface JwtServiceInterface
{
    public function createUser(Request $request);

    public function decode(Request $request);
}

<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 22:44
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
    }

    public function me(Request $request)
    {
        $user = $request->auth;


        return $user;
    }
}

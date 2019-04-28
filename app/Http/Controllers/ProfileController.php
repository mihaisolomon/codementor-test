<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 22:44
 */

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function __construct()
    {
    }

    public function me()
    {
        $user = \Auth::user();


        return $user;
    }
}

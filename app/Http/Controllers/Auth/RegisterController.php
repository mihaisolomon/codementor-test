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
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|unique:users,email|max:255',
            'name' => 'required|string|max:255',
            'password'=> 'required'
        ]);

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'avatar' => Gravatar::avatar($request->get('email'))
        ]);

        return response()->json(['success' => true], 200);
    }
}

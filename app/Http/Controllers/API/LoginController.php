<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {

        $user_name = $request->user_name;
        $email = $request->user_name;
        $password = $request->password;

        $credentials = [
            'user_name' => $user_name,
            'password' => $password
        ];
        $credentials_email = [
            'email' => $email,
            'password' => $password
        ];

        if (Auth::attempt($credentials) || Auth::attempt($credentials_email)) {
            return view('welcome');
        } else {
            return back();
        }
    }

}

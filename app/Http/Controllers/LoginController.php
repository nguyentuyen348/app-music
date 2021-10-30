<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('login.login');
    }

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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

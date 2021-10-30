<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('backend.login');
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

    public function showFormChangePassword()
    {
        return view('backend.change_password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $currentPassword = $user->password;
        if (!Hash::check($request->currentPassword, $currentPassword)) {
            return redirect()->back()->withErrors(['currentPassword' => 'Sai mật khẩu vui lòng thử lại']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

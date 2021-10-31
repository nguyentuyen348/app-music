<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user_name = $request->user_name;
        $email = $request->user_name;
        $password = $request->password;

        $credentials_username = [
            'user_name' => $user_name,
            'password' => $password
        ];
        $credentials_email = [
            'email' => $email,
            'password' => $password
        ];
        $token_username = JWTAuth::attempt($credentials_username);
        $token_email = JWTAuth::attempt($credentials_email);
        try {
            if ($token_username || $token_email) {
                return response()->json(compact('token_username', 'token_email'));
            }
        } catch (JWTException $exception) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(['error' => 'invalid_credentials'], 400);
    }
}

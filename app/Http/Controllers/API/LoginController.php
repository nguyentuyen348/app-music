<?php

namespace App\Http\Controllers\API;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Exceptions\JWTException;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $credentials_username = [
            'email' => $email,
            'password' => $password
        ];
        $token = JWTAuth::attempt($credentials_username);
        try {
            if ($token) {
                $data = [
                    'token' => $token,
                    'user' => Auth::user(),
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công'
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Email hoặc mật khẩu không chính xác, mời nhập lại!'
                ];
            }
            return response()->json($data);
        } catch (JWTException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Đăng xuất thành công'
                ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đăng xuất thất bại'
            ]);
        }
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {

                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}

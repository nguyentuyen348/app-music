<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user_name = $request->user_name;
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
                    'token'=> $token,
                    'user' => Auth::user()
                ];
                return response()->json($data);
            }
        } catch (JWTException $exception) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(['error' => 'invalid_credentials'], 400);
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

}

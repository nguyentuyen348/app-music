<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $token = JWTAuth::fromUser($user);
            DB::commit();
            $data = [
                'status' => 'success',
                'token' => $token,
                'user' => $user,
                'message' => 'Đăng ký thành công'
            ];
            return response()->json($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $data = [
                'status' => 'error',
                'message' => $exception->getMessage()
            ];
            return response()->json($data);
        }
    }
}

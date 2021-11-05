<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class UserController extends Controller
{
    public function profile($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(UpdateProfileUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->avatar = $request->avatar;
        $user->save();
        return response()->json(compact('user'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $currentPassword = $user->password;
        if (!Hash::check($request->currentPassword, $currentPassword)) {
            $data = [
                'status' => 'error',
                'message' => 'Sai mật khẩu hiện tại'];
            return response()->json($data);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $data = [
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công'];
        return response()->json($data);
    }
}

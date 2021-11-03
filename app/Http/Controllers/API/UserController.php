<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($id)
    {
        $user=User::findOrFail($id);
        return response()->json($user);
    }

    public function update(UpdateProfileUserRequest $request,$id)
    {
        $user=User::findOrFail($id);
        $user->full_name=$request->full_name;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->address=$request->address;
        if ($request->hasFile('avatar')){
            $path=$request->file('avatar');
            $avatar=$path->store('avatars','public');
            $user->avatar=$avatar;
        }
        $user->save();
        return response()->json(compact('user'));
    }
}

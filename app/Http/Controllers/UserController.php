<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($id)
    {
        $user=User::findOrFail($id);
        return view('backend.users.profile',compact('user'));
    }

    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('backend.users.edit',compact('user'));
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
        return redirect()->route('users.profile',$user->id);
    }
}

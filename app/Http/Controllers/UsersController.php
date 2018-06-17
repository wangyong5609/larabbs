<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $reuqest, User $user)
    {
        $user->update($reuqest->all());
        return redirect()->route('users.show',$user->id)->with('success','個人資料修改成功');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class UserInvitationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            // POSTだったらユーザー登録
            $validate_rule = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
            $this->validate($request, $validate_rule);
            $user = new \App\User();
            $user->role = \UserConst::ROLE_MEMBER;
            $user->team_id = Auth::user()->team_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect('home/');
        }
        return view('/user/invitation');
    }



}



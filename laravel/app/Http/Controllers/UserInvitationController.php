<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;
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
            // 招待完了メール送信
            $mail_data['name'] = $request->name;
            $mail_data['email'] = $request->email;
            $mail_data['password'] = $request->password;
            $mail_data['url'] = url('');
            $contact = $request->all();
            \Mail::to($request->email)
                ->send(new InvitationMail($mail_data)); // 引数にリクエストデータを渡す

            return redirect('home/');
        }
        return view('/user/invitation');
    }



}



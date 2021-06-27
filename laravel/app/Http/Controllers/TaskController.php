<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class TaskController extends Controller
{
    //
    public function index(Request $request){
        if ($request->isMethod('POST')){
            // チケット発行者チームID検証
            $leader_team_id = Auth::user()->team_id;
            // チケット発行先チームID検証
            $team_member = \App\User::where('id', $request->team_member)->select('team_id')->first();
            if ($leader_team_id == $team_member->team_id)
            {
                // バリデートルール

                // バリデート

                // セーブ

                // リダイレクト
                //

            } else {
                return('不正なユーザーIDです');
                exit;
            }


        }else {
            // ユーザーチーム取得
            $team_id = Auth::user()->team_id;
            // チームメンバーの名前とユーザーID取得
            $team_member = \App\User::select('id', 'name')->where('team_id', $team_id)->get();

            $team_member_list = $team_member->pluck('name','id');
            return view('/task/regist_task',compact('team_member_list'));
        }



    }
}

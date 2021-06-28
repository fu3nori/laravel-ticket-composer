<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
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
                $validate_rule = [
                    'team_member' => 'integer',
                    'task' => 'required','size:140',
                    'start' => 'required','date',
                    'end' => 'required','date',

                ];
                // バリデートメッセージ
                $message = [
                    'task.required' => 'タスク内容を入れてください',
                    'start.required' => '開始日を入力してください',
                    'end.required' => '締切日を入力してください',
                ];
                // バリデート
                $this->validate($request,$validate_rule, $message);

                // セーブ
                $ticket =new \App\Models\Ticket();
                $ticket->users_id = $request->team_member;
                $ticket->team_id = Auth::user()->team_id;
                $ticket->task = $request->task;
                $ticket->save();
                // 画面表示用ステータス
                $system ="タスク追加完了";
                $team_member = \App\User::select('id', 'name')->where('team_id', Auth::user()->team_id)->get();
                $team_member_list = $team_member->pluck('name','id');
                return view('/task/regist_task',compact('system','team_member_list'));
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
            $system = "タスクを追加してください";
            return view('/task/regist_task',compact('team_member_list','system'));
        }



    }
}

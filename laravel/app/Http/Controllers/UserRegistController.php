<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserRegistController extends Controller
{

    public function admin(){
        // 管理人が存在するか確認
        $admin = \App\User::where('role', 100)->count();
        // チームIDを確定、現在のチームID最大値より一つ多い
        $team_id = DB::table('users')->select('team_id')->orderBy('team_id', 'desc')->first();
        $team_id = json_decode(json_encode($team_id), true);


        if ($admin==0){
            return View('user.admin_regist');
        }else{
            abort(403);
        }
    }
    public function leader(){


        return View('user.leader_regist');
    }

}

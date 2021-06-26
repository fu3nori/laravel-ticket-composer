<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        // ロール判定
        if ($data['role'] == 'admin'){
            $data['role'] = \UserConst::ROLE_ADMIN;
        } elseif ($data['role'] == 'leader'){
            $data['role'] = \UserConst::ROLE_LEADER;
        } elseif ($data['role'] == 'member'){
            $data['role'] = \UserConst::ROLE_MEMBER;
        } else{
            abort(403);
        }

        // チームIDを確定、現在のチームID最大値より一つ多い
        $team_id = DB::table('users')->select('team_id')->orderBy('team_id', 'desc')->first();
        $team_id = json_decode(json_encode($team_id), true);

        // チームIDがなければ0を付与
        if ($team_id==null){
            $team_id['team_id'] = null;
            $team_id['team_id'] =0;
        }
        $team_id = ++$team_id['team_id'];

        return User::create([
            'team_id' => $team_id,
            'role' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}

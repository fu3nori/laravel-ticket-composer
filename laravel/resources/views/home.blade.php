@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <div class="card-body">
                    @if ($role == \App\Consts\UserConst::ROLE_LEADER)
                        <p><a href="{{action('TaskController@index')}}">
                            <button type="button">新規タスク作成</button>
                        </a></p>
                        <p><a href="{{action('AccountUpdateController@index')}}">
                            <button type="button">代表者アカウント修正</button>
                        </a></p>
                        <p><a href="{{action('UserInvitationController@index')}}">
                            <button type="button">新規メンバー招待</button>
                        </a></p>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

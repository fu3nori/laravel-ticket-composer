<?php
?>
@extends('layouts.app')

@section('content')
    <h2>タスク新規作成</h2>
    <div>
        <p>{{$system}}</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    {{ Form::open(['action' => 'TaskController@index']) }}
    <p>担当メンバー</p>
    <p>{{ Form::select('team_member', $team_member_list, null, ['class' => 'team_member']) }}</p>
    <p>タスク内容</p>
    <p>{{Form::text('task', null, ['class' => 'task', 'id' => 'inputName'])}}</p>

    <p>開始日</p>
    <input type="date" name="start" >
    <p>締切日</p>
    <input type="date" name="end" >
    <p>{{Form::submit('登録', ['class'=>'btn btn-primary btn-block'])}}</p>
    {{ Form::close() }}
@endsection

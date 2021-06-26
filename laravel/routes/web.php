<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return ('test');
});
Route::get('/user_regist/admin', 'UserRegistController@admin');
Route::get('/user_regist/leader', 'UserRegistController@leader');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// ログインユーザーのみ
Route::group(['middleware' => ['auth']], function () {
    Route::get('/user_invitation','UserInvitationController@index');
    Route::post('/user_invitation','UserInvitationController@index');
});

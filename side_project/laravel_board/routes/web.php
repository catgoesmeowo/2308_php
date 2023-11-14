<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
    return view('login');
});

Route::get('/user/login', [UserController::class, 'loginget'])->name('user.login.get'); // 로그인 화면 이동
Route::post('/user/login', [UserController::class, 'loginpost'])->name('user.login.post'); //로그인 처리
Route::get('/user/registration', [UserController::class, 'registrationget'])->name('user.registration.get'); //회원가입 확인
Route::post('/user/registration', [UserController::class, 'registrationpost'])->name('user.registration.post'); //로그인 처리

//GET|HEAD        user .................... task.index › UserController@index  로그인 화면 이동
//GET|HEAD        user/{user} ............. task.destroy › UserController@edit 로그인 처리

//GET|HEAD        user/create ............. task.create › UserController@create  회원 가입 화면 이동
//POST            user .................... task.store › UserController@store  회원 가입 처리

//GET|HEAD        user/{user} ............. task.show › UserController@show  회원 정보 화면 이동
//PUT|PATCH       user/{user} ............. task.update › UserController@update  회원 정보 수정 처리

//DELETE          user/{user} ............. task.destroy › UserController@destroy  회원 탈퇴 처리
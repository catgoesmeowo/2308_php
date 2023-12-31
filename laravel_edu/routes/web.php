<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// ------------------
// 라우트 정의
// ------------------
// java -> callback, php-> closure(class) 
/*
1. 클로저는 일반 함수와 다르게 외부 함수나 변수에 접근할 수 있다.
2. 클로저는 실행이 완료된 시점에도 함수의 상태와 내부 변수들의 상태 값은 유지된다.
 (외부함수가 소멸된 후에도 환경(변수)를 기억)
*/
Route::get('/hi', function(){
    return '안녕하세요.';
});

// 없는 뷰 파일을 리턴 할 때
// 뷰 리턴( 뷰 파일이 없으면 에러발생, 디버그모드 설정이 false면 500에러 true면 에러의 상세 정보 출력.)
Route::get('/myview',function(){
    return view('myview');
});

// -----------
// HTTP 메소드 대응하는 라우터
// 여러 라우터에 해당 될 경우 가장 마지막에 정의 된 것이 실행
// -----------
// get메소드로 localhost/home 으로 접속했을 때 home 라는 뷰 파일을 리턴해주세요
Route::get('/home', function(){
    return view('home');
});

Route::post('/home', function(){
    return '메소드 : POST';
});

Route::put('/home', function(){
    return '메소드 : Put';
});

Route::delete('/home', function(){
    return '메소드 : DELETE';
});

// -----------
// 라우트에서 파라미터 제어
// -----------
// 쿼리 스트링에 파라미터가 셋팅돼서 요청이 올 때 파라미터 획득
// Ex : http://localhost/query?id=123&name 
// 라우트에서 파라미터 제어를 하기 위해 use Illuminate\Http\Request;를 상단에 선언
Route::get('/query', function (Request $request) {
    return $request->id.", ".$request->name;
});
// URL 세그먼트로 지정 파라미터 획득
// segment : 나누다, 분할하다
Route::get('/segment/{id}', function ($id) {
    return '세그먼트 파라미터 : '.$id;
});
// Ex: http://localhost/segment/id
// 2개 이상의 세그먼트로 지정 파라미터 획득
Route::get('/segment/{id}/{name}', function ($id, $name) {
    return '세그먼트 파라미터 2개이상 : '.$id.', '.$name;
});

// 이렇게도 파라미터 획득 가능
// Ex: http://localhost/segment2/1/ttt
Route::get('/segment2/{id}/{name}', function (Request $request, $id) {
    return '세그먼트 파라미터 22222: '.$request->$id.', '.$id.','.$request->name;
});

// URL 세그먼트로 지정 파라미터 획득 : 기본값 설정
// Ex: http://localhost/segment3
Route::get('/segment3/{id?}', function ($id = 'base') {
    return 'segment3 : '.$id;
});

// --------------------
// 라우트 매칭 실패시 대체 라우트 정의
// --------------------
Route::fallback(function () {
    return '잘못된 경로를 입력하셨습니다.';
});

// --------------------
// 라우트의 이름 지정
// --------------------
Route::get('/name', function() {
    return view('name');
});
Route::get('/name/home/php504/root', function() {
    return '이름 없는 라우트';
});
Route::get('/name/home/php504/user', function() {
    return '이름 있는 라우트';
})->name('name.user');


// ----------
// 컨트롤러
// ----------
// 커멘드로 컨트롤러 생성 : php artisan make:controller 컨트롤러밍
// 문법입니다 이렇게 적으십셔.
// Ex : http://127.0.0.1:8000/test
use App\Http\Controllers\TestController;
Route::get('/test', [TestController::class, 'index'])->name('test.index');
// Router에서시작해서 test에서 test controller에서 index메소드를 실행 $name라는 변수에 값을 담아서 view로 화면을 출력
// 라우터에서 시작을 해 테스트 컨트롤러에 안에 있는 인덱스 메소드를 실행해 테스트라는 뷰를 보여줘야댐 네임이라는 변수 안에 미스터 존이라는 값을 포함해서 보여줘라 ㅇㅇ
// class안에 있는 함수 = method
//  php artisan make:controller 컨트롤러명 --resource라는 메소드 사용시 url과 name(actionmethod)를 세팅해줌
use App\Http\Controllers\TaskController;
Route::resource('/task', TaskController::class);
//GET|HEAD        task .................... task.index › TaskController@index  리스트페이지
//POST            task .................... task.store › TaskController@store  저장버튼
//GET|HEAD        task/create ............. task.create › TaskController@create  인서트페이지
//GET|HEAD        task/{task} ............. task.show › TaskController@show  상세페이지
//PUT|PATCH       task/{task} ............. task.update › TaskController@update  수정버튼
//DELETE          task/{task} ............. task.destroy › TaskController@destroy  삭제버튼
//GET|HEAD        task/{task}/edit ........ task.edit › TaskController@edit 삭제페이지
// {task} 세그먼트 파라미터 segment(분할하다)

// 블레이드 템플릿용
Route::get('/child1', function() {
    $arr = [
         'name' => '김뽀삐'
         ,'age' => 130
         ,'gender' => '여자'
    ];
    $arr2 = [];
    return view('child1')
         ->with('gender', '3')
         ->with('data', $arr)
         ->with('data2', $arr2);
});



Route::get('/child2', function() {
    return view('child2');
});


// DB관련 실습용
use App\Http\Controllers\BoardController;
Route::get('/boards', [BoardController::class, 'index'])->name('board.index');
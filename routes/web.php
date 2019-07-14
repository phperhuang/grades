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


Route::get('user', function () {
    echo 123;
});

Route::group(['prefix' => 'user'], function () {
    Route::get('login', "User\LoginController@login");
    Route::post('login', "User\LoginController@checkLogin");
    Route::get('logout', "User\LoginController@logout");

    // 成绩路由
    Route::any('show_grades', "User\UserController@showGrades");
    Route::get('show', "User\UserController@home");
    Route::get('entering_grades', 'User\UserController@enteringGrades');
    Route::post('enter_grades_result', 'User\UserController@enterGradesResult');

    // 班级路由
    Route::get('add_classinfo', 'User\UserController@addClassInfo');
    Route::post('add_classinfo_result', 'User\UserController@addClassInfoResult');
    Route::get('class_list', 'User\UserController@classList');

    // 考试描述路由
    Route::get('test_describe_list', 'User\UserController@testDescribeList');
    Route::get('add_test_describe', 'User\UserController@addTestDescribe');
    Route::post('add_test_describe_result', 'User\UserController@addTestDescribeResult');

    Route::get('sessions', function () {
        var_dump(session()->all());
    });
});
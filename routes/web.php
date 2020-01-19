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
    Route::post('upload_excel_class', 'User\UserController@uploadExcelClass');

    // 考试描述路由
    Route::get('test_describe_list', 'User\UserController@testDescribeList');
    Route::get('add_test_describe', 'User\UserController@addTestDescribe');
    Route::post('add_test_describe_result', 'User\UserController@addTestDescribeResult');

    // 生成周测题目路由
    Route::get('test_index', 'User\UserController@testIndex');
//    Route::get('create_test', 'User\UserController@exportWord');
//    Route::get('create_a_test', 'User\UserController@exportNewWord');
    Route::get('create_test', 'User\UserController@exportWord');
    // 家长会签到路由
    Route::get('parents_sign', 'User\UserController@parentsSignIndex');
    Route::post('parents_sign', 'User\UserController@parentsSign');

    Route::get('sessions', function () {
        var_dump(session()->all());
    });

    // 学生成绩
    Route::get('stu_grade', 'User\UserController@stuGrade');


});

Route::get('sort', function (){
    function order($arr){
        $count = count($arr);
        $temp = 0;
        for($i=0; $i<$count-1; $i++){
            for ($j=0; $j< $count-1-$i; $j++){
                if($arr[$j] > $arr[$j+1]){
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $temp;
                }
            }
        }
        return $arr;
    }


    $arr= array(6,3,8,2,9,1);
    $res =  order($arr);
    print_r($res);
});

Route::get('get_token', function (){
//    echo base64_encode('hxLzkk20150707');
    $str = 'hxlzkk20150707by';
//    $str = 'aHhMemtrMjAxNTA3MDc=';
    echo $en_str = base64_encode($str);
    echo "<br>";
    echo $de_str = base64_decode($en_str);
//    echo md5($en_str);
});

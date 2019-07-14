<?php

namespace App\Http\Controllers\User;

use App\ClassInfo;
use App\Subject;
use App\TestDescribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function home()
    {
        return view('user/index/index');
    }

    public function enteringGrades()
    {
        $class_nos = ClassInfo::orderBy('class_no')->get();
        $tests = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'id']);
        if(count($tests) == 0){
            $tests = [];
        }
        if(count($class_nos) == 0){
            $class_nos = [];
        }
        return view('user/index/entering_grades', ['tests' => $tests, 'class_nos' => $class_nos, 'data' => 23]);
    }

    public function showGrades(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $testData = Subject::where('describe_id', $request->input('describe_id'))->orderBy('class')->get();
            if(count($testData) == 0){
                $testData = [];
            }
            return $testData;
        }else{
            $tests = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'id']);
            if(count($tests) == 0){
                $tests = [];
            }
        }
        return view('user/index/show_grades', ['tests' => $tests]);
    }

    public function enterGradesResult(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $all = $request->except('_token');
            try{
                $grades_result = Subject::create(['class' => $all['class_no'], 'chinese' => $all['chinese'], 'math' => $all['math'],
                    'english' => $all['english'], 'political' => $all['political'], 'history' => $all['history'], 'biology' => $all['biology'],
                    'describe_id' => $all['describe'], 'geography' => $all['geography']]);
                return redirect(url('user/show_grades'));
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }

    }

    // 班级列表信息
    public function classList()
    {
        $data = ClassInfo::orderBy('class_no')->get();
        return view('user/index/show_class_info', ['data' => $data]);
    }

    // 加入班级
    public function addClassInfo()
    {
        return view('user/index/add_class');
    }

    // 处理加入班级
    public function addClassInfoResult(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $all = $request->except('_token');
            try{
                $class_info = ClassInfo::create(['class_no' => $all['class_no'], 'manager' => $all['manager']]);
                return view('user/index/add_class', ['message' => '成功添加班级信息', 'code' => 0]);
            }catch (\Exception $e){
                return ['message' => 'error'];
            }

        }
    }

    /*
     * 考试描述列表
     * */
    public function testDescribeList(TestDescribe $testDescribe)
    {
        $data = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'test_date']);
        if(count($data) == 0){
            $data = [];
        }
        return view('user/index/test_describe_list', ['data' => $data]);
    }

    // 添加考试描述
    public function addTestDescribe()
    {
        return view('user/index/add_describe');
    }

    /*
     * 处理添加考试描述
     * */
    public function addTestDescribeResult(Request $request)
    {
        $data = $request->except('_token');
        try{
            TestDescribe::create(['describe' => $data['describe'], 'test_date' => $data['test_date']]);
            return redirect(url('user/test_describe_list'));
//            return json_encode(['message' => 'success'], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $e){
            return json_encode(['message' => 'error'], JSON_UNESCAPED_UNICODE);
        }
    }


}

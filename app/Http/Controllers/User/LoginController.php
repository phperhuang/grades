<?php

namespace App\Http\Controllers\User;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//use Validator;

class LoginController extends Controller
{
    //

    public function login()
    {

        return view("user.auth.login");
    }

    public function checkLogin(Admin $admin)
    {
        $all = request()->except("_token");
        if($all['user'] == '' || $all['password'] == ''){
            $this->saveErr('error_msg', '用户名或密码错误...');
            return redirect()->back();
        }else{
            $data = $admin->where('username', $all['user'])->first();
            if(empty($data) || $data->password != $all['password']){
                $this->saveErr('error_msg', '该用户不存在或密码错误...');
                return redirect()->back();
            }
            return redirect(url('user/show'));
//            return view('user/index/index');
        }
    }

    public function saveErr($errName, $errVal)
    {
        session()->put($errName, $errVal);
    }

    public function logout()
    {
        session()->flush();
        return redirect(url('user/login'));
    }

}

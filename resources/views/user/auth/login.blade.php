<?php

//session_start();
//
//if (isset($_POST['user'])) {
//
//    $user = $_POST['user'];
//
//    $password = $_POST['password'];
//
//    if ($user == 'admin' && $password == '123456') {//验证正确
//
//        $_SESSION['user'] = $user;
//
//        //跳转到首页
//
//        header('location:http://127.0.0.1/daohang/admin/index.php');
//
//    }else{
//
//        echo "<script>alert('登录失败，用户名或密码不正确');</script>";
//
//        exit();
//
//    }
//
//}

?>
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>登录</title>
    <link rel="stylesheet" href="{{ url("css/layui/css/layui.css") }}">
    <style>
        .window{
            width: 400px;
            position: absolute;
            margin-left: -200px;
            margin-top: -80px;
            top: 50%;
            left: 50%;
            display: block;
            z-index: 2000;
            background: #fff;
            /*padding: 200;*/
        }
    </style>

</head>

<body style="background: #f1f1f1;">

<div class="window">
    <form class="layui-form" method="post" action="{{ url("user/login") }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="layui-form-item" style="margin-right: 100px;margin-top: 20px;">
            <label class="layui-form-label">用户名：</label>
            <div class="layui-input-block">
                <input type="text" name="user" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
            <div class="layui-input-inline">
                <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <input type="checkbox" name="" title="写作" lay-skin="primary" checked>
            {{--<div style="margin-left: 50px;margin-bottom: 10px;" class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>保持登录7天</span><i class="layui-icon"></i></div>--}}
            <div style="text-align: center;">
                <input type="submit" class="layui-btn"  value="登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录"/>
            </div>
        </div>
    </form>

</div>
<script type="text/javascript">
    $(function () {
        layui.use("layer",function(){
            <?php
            if(session()->has('error_msg')){
                $error_msg = session()->pull('error_msg');
            ?>
                layer.alert("{{ $error_msg }}");
            <?php
            }
            ?>
        });
    })
</script>
</body>

</html>
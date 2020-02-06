@extends('.common.index')

@section('content')

    <script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>
    <script>
        $(function () {
            layui.use("layer",function(){
            });
        })
    </script>

    {{--<form class="layui-form" action="{{ url('user/add_classinfo_result') }}" method="post">--}}
        {{--<input type="hidden" value="{{ csrf_token() }}" name="_token">--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">班级编号</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="class_no" required  lay-verify="required" placeholder="请输入班级编号" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">班主任姓名</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="manager" required  lay-verify="required" placeholder="请输入班主任姓名" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<div class="layui-input-block">--}}
                {{--<button type="submit" class="layui-btn">立即提交</button>--}}
                {{--<button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
                {{--<button type="reset" class="layui-btn layui-btn-warm"><a href="{{ url('user/class_list') }}">返回</a></button>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</form>--}}

    <style type="text/css">
        #tjform {
            margin-top: 10px;
            margin-left: 10px;
        }

    </style>

    <form action="{{ url('user/add_classinfo_result') }}" method="post" id="tjform" class="form-horizontal style-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label style="text-align: center; margin-top: 3px;" class="control-label col-md-1">班级编号</label>
            <div class="col-md-2">
                <input class="form-control form-control-inline input-medium default-date-picker" name="class_no" required placeholder="请输入班级编号" size="16" type="text" value="">
            </div>
        </div>
        <div class="form-group">
            <label style="text-align: center; margin-top: 3px;" class="control-label col-md-1">班主任姓名</label>
            <div class="col-md-2">
                <input class="form-control form-control-inline input-medium default-date-picker" name="manager" required placeholder="请输入班主任姓名" size="16" type="text" value="">
            </div>
            </div>
        </div>
        <input class="btn btn-primary" type="submit" value="提交">
        <button type="reset" class="btn btn-warning"><a href="{{ url('user/class_list') }}">返回</a></button>

    </form>

    {{--<form>--}}
        {{--<fieldset>--}}
            {{--<legend>添加班级信息</legend>--}}
            {{--<label>班级编号</label>--}}
            {{--<input type="text" placeholder="请输入班级编号">--}}
            {{--<span class="help-block">Example block-level help text here.</span>--}}
            {{--<button type="submit" class="btn">Submit</button>--}}
        {{--</fieldset>--}}
    {{--</form>--}}

    {{--<form class="">--}}
        {{--<div class="control-group">--}}
            {{--<label class="control-label" for="inputEmail">班级编号</label>--}}
            {{--<div style="display: inline-block;" class="controls">--}}
                {{--<input type="text" placeholder="请输入班级编号">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="control-group">--}}
            {{--<label class="control-label" for="inputPassword">班主任姓名</label>--}}
            {{--<div class="controls">--}}
                {{--<input type="password" placeholder="请输入班主任姓名">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="control-group">--}}
            {{--<div class="controls">--}}
                {{--<button type="submit" class="btn">Sign in</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

@endsection
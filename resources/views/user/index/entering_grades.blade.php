@extends('.common.index')

@section('content')
    <script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>

    {{--<form class="layui-form" action="{{ url('user/enter_grades_result') }}" method="post">--}}
        {{--<input type="hidden" value="{{ csrf_token() }}" name="_token">--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">选择班级</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<select name="class_no" lay-verify="required">--}}
                    {{--<option value=""></option>--}}
                    {{--@if(!empty($class_nos))--}}
                        {{--@foreach($class_nos as $class_no)--}}
                            {{--<option value="{{ $class_no->class_no }}">{{ $class_no->class_no }}</option>--}}
                        {{--@endforeach--}}
                    {{--@else--}}
                        {{--<option value=""></option>--}}
                    {{--@endif--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">选择考试</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<select name="describe" lay-verify="required">--}}
                    {{--<option value=""></option>--}}
                    {{--@if(!empty($tests))--}}
                        {{--@foreach($tests as $test)--}}
                            {{--<option value="{{ $test->id }}">{{ $test->describe }}</option>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">语文</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="chinese" required  lay-verify="required" placeholder="请输入语文成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">数学</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="math" required  lay-verify="required" placeholder="请输入数学成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">英语</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="english" required  lay-verify="required" placeholder="请输入英语成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">政治</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="political" required  lay-verify="required" placeholder="请输入政治成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">历史</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="history" required  lay-verify="required" placeholder="请输入历史成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">地理</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="geography" required  lay-verify="required" placeholder="请输入地理成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">生物</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="biology" required  lay-verify="required" placeholder="请输入生物成绩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}


        {{--<div class="layui-form-item">--}}
            {{--<div class="layui-input-block">--}}
                {{--<button type="submit" class="layui-btn">立即提交</button>--}}
                {{--<button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

    {{--<select name="class_no" lay-verify="required">--}}
        {{--<option value="">--请选择班级--</option>--}}
        {{--@if(!empty($class_nos))--}}
            {{--@foreach($class_nos as $class_no)--}}
                {{--<option value="{{ $class_no->class_no }}">{{ $class_no->class_no }}</option>--}}
            {{--@endforeach--}}
        {{--@else--}}
            {{--<option value=""></option>--}}
        {{--@endif--}}
    {{--</select>--}}

    <select id="describe" class="form-control" style="width: 300px;margin-top: 10px;margin-left: 10px;">
        <option value="">--请选择班级--</option>
        @if(!empty($class_nos))
            @foreach($class_nos as $class_no)
                <option value="{{ $class_no->class_no }}">{{ $class_no->class_no }}</option>
            @endforeach
        @else
            <option value=""></option>
        @endif
    </select>

    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <form role="form" class="form-horizontal style-form">
                    <div class="form-group has-success">
                        <label class="col-md-1 control-label">First Name</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="f-name" class="form-control">
                            <p class="help-block">Successfully done</p>
                        </div>
                    </div>
                    <div class="form-group has-error">
                        <label class="col-md-1 control-label">Last Name</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="" id="l-name" class="form-control">
                            <p class="help-block">Aha you gave a wrong info</p>
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="col-md-1 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" placeholder="" id="email2" class="form-control">
                            <p class="help-block">Something went wrong</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-theme" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /form-panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>



    <form style="margin-left: 110px;" action="{{ url('user/upload_excel_class') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="layui-btn" type="file" name="upload_file">
        <button type="submit" class="layui-btn" id="upload_file">开始上传</button>
    </form>


    <script>
        //Demo
        $(function () {
            layui.use("layer",function(){
            });
        });
    </script>
@endsection
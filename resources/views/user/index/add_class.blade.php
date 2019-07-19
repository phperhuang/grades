@extends('.common.index')

@section('content')

    <script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>
    <script>
        $(function () {
            layui.use("layer",function(){
            });
        })
    </script>

    <form class="layui-form" action="{{ url('user/add_classinfo_result') }}" method="post">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <div class="layui-form-item">
            <label class="layui-form-label">班级编号</label>
            <div class="layui-input-block">
                <input type="text" name="class_no" required  lay-verify="required" placeholder="请输入班级编号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">班主任姓名</label>
            <div class="layui-input-block">
                <input type="text" name="manager" required  lay-verify="required" placeholder="请输入班主任姓名" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                <button type="reset" class="layui-btn layui-btn-warm"><a href="{{ url('user/class_list') }}">返回</a></button>
            </div>
        </div>



    </form>

@endsection
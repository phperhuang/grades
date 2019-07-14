@extends('.common.index')

@section('content')

{{--    <script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>--}}
    <script type="text/javascript" src="{{ url('css/layui/laydate/laydate.js') }}"></script>

    <form class="layui-form" action="{{ url('user/add_test_describe_result') }}" method="post">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <div class="layui-form-item">
            <label class="layui-form-label">考试时间</label>
            <div class="layui-input-block">
                <input type="text" name="test_date" id="test_date" required  lay-verify="required" placeholder="请输入此次考试的时间" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述此考试</label>
            <div class="layui-input-block">
                <input type="text" name="describe" required  lay-verify="required" placeholder="请输入此次考试的描述，如 2019年3月月考" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                <button type="reset" class="layui-btn layui-btn-warm"><a href="{{ url('user/test_describe_list') }}">返回</a></button>
            </div>
        </div>

    </form>

    <script>
        laydate.render({
            elem: '#test_date' //指定元素
        });
    </script>

@endsection
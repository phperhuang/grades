@extends('.common.index')

@section('content')
    <script src="{{ url('js/echarts.js') }}"></script>
{{--    <script src="{{ url('js/echarts-gl.min.js') }}"></script>--}}

    <div class="layui-form-item">
        <label class="layui-form-label">选择考试</label>
        <div class="layui-input-block">
            <select lay-filter="describe" name="describe" id="describe" lay-verify="required">
                <option value=""></option>
                @if(!empty($tests))
                    @foreach($tests as $test)
                        <option value="{{ $test->id }}">{{ $test->describe }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>班级</th>
            <th>语文</th>
            <th>数学</th>
            <th>英语</th>
            <th>政治</th>
            <th>历史</th>
            <th>地理</th>
            <th>生物</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        <div id="grades" style="width: 1200px;height:400px; display: none;"></div>

    <script src="{{ url('js/common.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            layui.use('form', function() {
                var form = layui.form;
                form.on('select(describe)', function(data){
                    let prams = {"describe_id" : data.value, "_token" : "{{ csrf_token() }}"}
                    let side_alllength = $('.layui-side').css('width');
                    let side_length = side_alllength.substr(0, +(side_alllength.length - 2));
                    $('#grades').css('width', +(document.body.clientWidth - side_length - 5));
                    $('#grades').css('display', 'block');
                    postAjax("{{ url('user/show_grades') }}", prams, $('table tbody'));
                });
            });

        });

    </script>

@endsection
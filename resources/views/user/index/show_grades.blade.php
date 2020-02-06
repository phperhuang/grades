@extends('.common.index')

@section('content')
    <style type="text/css">
        .num {
            /*float: right;*/
            margin-left: 45px;
            text-align: center;
        }
        .paiming {
            margin-left: 10px;
        }
        table tbody td {
            margin-left: 50px;
        }
    </style>

    <script src="{{ url('js/common.js') }}"></script>
    <script src="{{ url('css/layui/layui.js') }}"></script>
    <script src="{{ url('css/layui/layui.all.js') }}"></script>
    <script src="{{ url('css/layui/lay/modules/form.js') }}"></script>


    <select id="describe" class="form-control" style="width: 300px;margin-top: 10px;margin-left: 10px;">
        <option value="">--请选择考试--</option>
        @if(!empty($tests))
            @foreach($tests as $test)
                <option value="{{ $test->id }}">{{ $test->describe }}</option>
            @endforeach
        @endif
    </select>

    <table class="table table-hover">
        <colgroup>
        <col width="150">
        <col width="200">
        <col>
        </colgroup>
        <thead>
        <tr>
        <th>班级</th>
        <th>语文<span class="paiming">年级排名</span></th>
        <th>数学<span class="paiming">年级排名</span></th>
        <th>英语<span class="paiming">年级排名</span></th>
        <th>物理<span class="paiming">年级排名</span></th>
        <th>政治<span class="paiming">年级排名</span></th>
        <th>历史<span class="paiming">年级排名</span></th>
        <th>地理<span class="paiming">年级排名</span></th>
        <th>生物<span class="paiming">年级排名</span></th>
        <th>化学<span class="paiming">年级排名</span></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="grades" style="width: 1200px;height:400px; display: none;"></div>


    <script type="text/javascript">
        $(function () {
            {{--layui.use('form', function() {--}}
                {{--var form = layui.form;--}}
                {{--form.on('select[name=describe])', function(data){--}}
                    {{--// layer.alert('www');--}}
                    {{--console.log('eee')--}}
                    {{--let prams = {"describe_id" : data.value, "_token" : "{{ csrf_token() }}"}--}}
                    {{--let side_alllength = $('.layui-side').css('width');--}}
                    {{--let side_length = side_alllength.substr(0, +(side_alllength.length - 2));--}}
                    {{--$('#grades').css('width', +(document.body.clientWidth - side_length - 5));--}}
                    {{--$('#grades').css('display', 'block');--}}
                    {{--postAjax("{{ url('user/show_grades') }}", prams, $('table tbody'));--}}
                {{--});--}}
            {{--});--}}


            $('#describe').change(function () {
                let prams = {"describe_id" : $(this).children('option:selected').val(), "_token" : "{{ csrf_token() }}"}
                $('#grades').css('display', 'block');
                postAjax("{{ url('user/show_grades') }}", prams, $('table tbody'));
            });
        });

    </script>

@endsection
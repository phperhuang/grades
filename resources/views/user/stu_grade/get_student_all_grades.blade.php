@extends('.common.index')


@section('content')

    <style type="text/css">
        .layui-edge {
            display: none;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle!important;
        }
        .show_grades {
            margin-bottom: 50px;!important;
        }
    </style>
    {{--{{ var_dump($test_describe) }}--}}
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="form-group">
                    {{--<select style="display: inline-block; width: 200px;" class="form-control" name="show_grade_describe" id="show_grade_describe">--}}
                        {{--<option value="">--请选择考试--</option>--}}
                        {{--@foreach($test_describe as $describe)--}}
                            {{--<option value="{{ $describe }}">{{ $describe }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                    <select style="display: inline-block; width: 200px;" class="form-control" name="ten_class" id="ten_class">
                        <option value="">--请选择班级--</option>
                        @foreach($class_info as $cInfo)
                            <option value="{{ $cInfo }}">{{ $cInfo }}</option>
                        @endforeach
                    </select>
                    <button id="show_stu_grades" style="margin-top: -4px; margin-left: 20px;" type="button" class="btn btn-primary">
                        查看成绩
                    </button>
                </div>

            </div>
            <!-- /form-panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>

    {{--<table class="table table-hover" id="show_student_grades">--}}
        {{--<thead>--}}
        {{--<th>姓名</th><th>学期</th><th>时间</th><th>班级排名</th><th>年级排名</th><th>语文</th><th>数学</th><th>英语</th>--}}
        {{--<th>政治</th><th>物理</th><th>历史</th><th>地理</th><th>生物</th><th>化学</th><th>总分</th>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--</tbody>--}}
    {{--</table>--}}
    <div class="show_change_grades">

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover show_ten">
                        <thead>
                        <tr>
                            <td>姓名</td>
                            <td>分数</td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('js/show_grades.js') }}"></script>
    <script type="text/javascript">
        // getTenGrades();
        $(function () {
            $('#show_stu_grades').on('click', function () {
                let class_no = $('#ten_class option:selected').text();
                let prams = {"class_no" : class_no, '_token' : "{{ csrf_token() }}"}
                showStudentAllGrades("{{ url('user/show_student_all_grades') }}", prams, $('.show_change_grades'));
            })
        });
    </script>

@endsection
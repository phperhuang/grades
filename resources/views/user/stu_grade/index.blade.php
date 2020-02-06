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
    </style>

    {{--<form action="" method="post" enctype="multipart/form-data">--}}
        {{--<span>导入学生成绩</span>--}}
        {{--<input type="file" name="stu_grade" />--}}

    {{--</form>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">选择班级</label>--}}
            {{--<div class="layui-input-block" style="width: 200px;">--}}
                {{--<select name="class_no">--}}
                    {{--<option>--请选择班级--</option>--}}
                    {{--<option value="">123</option>--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}

    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <form action="{{ url('user/upload_excel_stu_grades') }}" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <div class="form-group">
                        <label class="control-label col-md-1">上传班级成绩</label>
                        <div class="col-md-1">
                            <input style="padding-top: 8px;" type="file" name="upload_file" class="default" />
                        </div>
                        <select name="class_no" class="form-control" style="width: 300px;margin-left: 150px; display: inline-block">
                            <option value="">--请选择班级--</option>
                            @foreach($class_info as $cInfo)
                                <option value="{{ $cInfo }}">{{ $cInfo }}</option>
                            @endforeach
                        </select>
                        <select name="describe" class="form-control" style="width: 300px;margin-left: 50px; display: inline-block">
                            <option value="">--请选择考试--</option>
                            @foreach($test_describe as $describe)
                                <option value="{{ $describe }}">{{ $describe }}</option>
                            @endforeach
                        </select>
                        <select name="level" class="form-control" style="width: 200px;margin-left: 50px; display: inline-block">
                            <option value="1">初中一年级</option>
                            <option value="2">初中二年级</option>
                            <option value="3">初中三年级</option>
                        </select>
                        <input type="submit" class="btn btn-primary" style="margin-left: 15px; margin-top: -6px;" value="提交">
                    </div>
                </form>
                <div class="form-group">
                    <select style="display: inline-block; width: 200px;" class="form-control" name="show_grade_describe" id="show_grade_describe">
                        <option value="">--请选择考试--</option>
                        @foreach($test_describe as $describe)
                            <option value="{{ $describe }}">{{ $describe }}</option>
                        @endforeach
                    </select>
                    <select style="display: inline-block; width: 200px;" class="form-control" name="ten_class" id="ten_class">
                        <option value="">--请选择班级--</option>
                        @foreach($class_info as $cInfo)
                            <option value="{{ $cInfo }}">{{ $cInfo }}</option>
                        @endforeach
                    </select>
                    <select style="display: inline-block; width: 200px;" class="form-control" name="ten_stu" id="ten_stu">
                        <option value="chinese">语文前十名</option>
                        <option value="math">数学前十名</option>
                        <option value="english">英语前十名</option>
                    </select>
                    <button id="show_stu_grades" style="margin-top: -4px; margin-left: 20px;" type="button" class="btn btn-primary">
                        查看成绩
                    </button>
                    <button id="show_ten_stu" style="margin-top: -4px; margin-left: 20px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        显示前十名
                    </button>
                </div>

            </div>
            <!-- /form-panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>

    <table class="table table-hover" id="show_student_grades">
        <thead>
            <th>姓名</th><th>语文</th><th>数学</th><th>英语</th><th>政治</th><th>历史</th><th>地理</th>
            <th>生物</th><th>物理</th><th>化学</th><th>总分</th><th>班级排名</th><th>年级排名</th>
        </thead>
        <tbody>
            @foreach($students_grades as $students)
                <tr>
                    <td>{{ $students->stu_name }}</td><td>{{ $students->chinese }}</td>
                    <td>{{ $students->math }}</td><td>{{ $students->english }}</td>
                    <td>{{ $students->political }}</td><td>{{ $students->history }}</td>
                    <td>{{ $students->geography }}</td><td>{{ $students->biology }}</td>
                    <td>{{ $students->chemical }}</td><td>{{ $students->physical }}</td>
                    <td>{{ $students->total_points }}</td><td>{{ $students->class_ranking }}</td>
                    <td>{{ $students->grade_ranking }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
            $('#show_ten_stu').on('click', function () {
                let subject = $('#ten_stu option:selected').val();
                let class_no = $('#ten_class option:selected').text();
                let prams = {"subject" : subject, 'class_no' : class_no, '_token' : "{{ csrf_token() }}"}
                $("#exampleModalLabel").text($('#ten_stu option:selected').text());
                postAjaxTen("{{ url('user/get_ten_students') }}", prams, $('.show_ten tbody'));
            });

            $('#show_stu_grades').on('click', function () {
                let class_no = $('#ten_class option:selected').text();
                let test_describe = $('#show_grade_describe').val();
                let prams = {"class_no" : class_no, "test_describe" : test_describe, '_token' : "{{ csrf_token() }}"}
                getClassGrades("{{ url('user/get_student_grades') }}", prams, $("#show_student_grades tbody"));
            })
        });
    </script>

@endsection
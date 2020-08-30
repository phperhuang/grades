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
{{--    {{ var_dump($test_describe) }}--}}
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="form-group">
                    <select style="display: inline-block; width: 200px;" class="form-control" name="show_grade_describe" id="first_describe">
                    <option value="">--请选择上次考试--</option>
                    @foreach($test_describe as $describe)
                        <option value="{{ $describe['describe'] }}">{{ $describe['describe'] }}</option>
                    @endforeach
                    </select>
                    <select style="display: inline-block; width: 200px;" class="form-control" name="show_grade_describe" id="last_describe">
                        <option value="">--请选择此次考试--</option>
                        @foreach($test_describe as $describe)
                            <option value="{{ $describe['describe'] }}">{{ $describe['describe'] }}</option>
                        @endforeach
                    </select>
                    <select style="display: inline-block; width: 200px;" class="form-control" name="ten_class" id="ten_class">
                        <option value="">--请选择班级--</option>
                        @foreach($class_info as $cInfo)
                            <option value="{{ $cInfo['class_no'] }}">{{ $cInfo['class_no'] }}</option>
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

    <table class="table table-hover" id="show_student_progress">
    <thead>
    <th>姓名</th><th>上次排名</th><th>此次排名</th><th>进步名词</th>
    </thead>
    <tbody>
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
            $('#show_stu_grades').on('click', function () {
                let class_no = $('#ten_class option:selected').text();
                let first_describe = $('#first_describe option:selected').text();
                let last_describe = $('#first_describe option:selected').text();
                let prams = {"class_no" : class_no, "first_describe" : first_describe, "last_describe" : last_describe,'_token' : "{{ csrf_token() }}"}
                showStudentProgress("{{ url('user/show_progress_ten') }}", prams, $('#show_student_progress tbody'));
            })
        });
    </script>

@endsection
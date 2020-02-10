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

    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <form action="{{ url('user/expload_dztm') }}" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <div class="form-group">
                        <label class="control-label col-md-1">上传班级成绩</label>
                        <div class="col-md-1">
                            <input style="padding-top: 8px;" type="file" name="upload_file" class="default" />
                        </div>
                        <select name="class_no" class="form-control class_no" style="width: 300px;margin-left: 150px; display: inline-block">
                            <option value="">--请选择班级--</option>
                            @foreach($class_info as $cInfo)
                                <option value="{{ $cInfo }}">{{ $cInfo }}</option>
                            @endforeach
                        </select>
                        <select name="describe" class="form-control describe" style="width: 300px;margin-left: 50px; display: inline-block">
                            <option value="">--请选择考试--</option>
                            @foreach($test_describe as $describe)
                                <option value="{{ $describe }}">{{ $describe }}</option>
                            @endforeach
                        </select>
                        <select name="level" class="form-control level" style="width: 200px;margin-left: 50px; display: inline-block">
                            <option value="1">初中一年级</option>
                            <option value="2">初中二年级</option>
                            <option value="3">初中三年级</option>
                        </select>
                        <input type="submit" class="btn btn-primary expload" style="margin-left: 15px; margin-top: -6px;" value="提交">
                    </div>
                </form>

            </div>
            <!-- /form-panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>

    {{--<script type="text/javascript">--}}
        {{--$(function () {--}}
            {{--$('.expload').on('click', function () {--}}
                {{--let class_no = $('.class_no option:selected').val();--}}
                {{--let level = $('.level option:selected').val();--}}
                {{--let describe = $('.describe option:selected').val();--}}
                {{--$.post("{{ url('user/expload_dztm') }}",--}}
                    {{--{class_no : class_no, level : level, describe : describe, '_token' : "{{ csrf_token() }}"}, function (data) {--}}
                    {{--alert('yyy');--}}
                {{--});--}}
                {{--{{ url('user/expload_dztm') }}--}}
            {{--})--}}
        {{--})--}}
    {{--</script>--}}

@endsection
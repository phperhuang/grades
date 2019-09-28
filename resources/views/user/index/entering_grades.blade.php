@extends('.common.index')

@section('content')
    <script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>

    <form class="layui-form" action="{{ url('user/enter_grades_result') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <div class="layui-form-item">
            <label class="layui-form-label">选择班级</label>
            <div class="layui-input-block">
                <select name="class_no" lay-verify="required">
                    <option value=""></option>
                    @if(!empty($class_nos))
                        @foreach($class_nos as $class_no)
                            <option value="{{ $class_no->class_no }}">{{ $class_no->class_no }}</option>
                        @endforeach
                    @else
                        <option value=""></option>
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择考试</label>
            <div class="layui-input-block">
                <select name="describe" lay-verify="required">
                    <option value=""></option>
                    @if(!empty($tests))
                        @foreach($tests as $test)
                            <option value="{{ $test->id }}">{{ $test->describe }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">语文</label>
            <div class="layui-input-block">
                <input type="text" name="chinese" required  lay-verify="required" placeholder="请输入语文成绩" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数学</label>
            <div class="layui-input-block">
                <input type="text" name="math" required  lay-verify="required" placeholder="请输入数学成绩" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">英语</label>
            <div class="layui-input-block">
                <input type="text" name="english" required  lay-verify="required" placeholder="请输入英语成绩" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">政治</label>
            <div class="layui-input-block">
                <input type="text" name="political" required  lay-verify="required" placeholder="请输入政治成绩" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">历史</label>
            <div class="layui-input-block">
                <input type="text" name="history" required  lay-verify="required" placeholder="请输入历史成绩" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">地理</label>
            <div class="layui-input-block">
                <input type="text" name="geography" required  lay-verify="required" placeholder="请输入地理成绩" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">生物</label>
            <div class="layui-input-block">
                <input type="text" name="biology" required  lay-verify="required" placeholder="请输入生物成绩" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                <div class="layui-upload" style="display: inline;">
                    <button type="button" class="layui-btn layui-btn-normal" id="choose_file">选择文件</button>
                    <button type="button" class="layui-btn" id="upload_file">开始上传</button>
                </div>
            </div>
        </div>



    </form>

    <script>
        //Demo
        $(function () {
            layui.use("layer",function(){
            });

            layui.use('upload', function() {
                var $ = layui.jquery
                    , upload = layui.upload;
                upload.render({
                    elem: '#choose_file'
                    ,url: "{{url('user/upload_xcel_class')}}"
                    ,auto: false
                    //,multiple: true
                    ,bindAction: '#upload_file'
                    ,done: function(res){
                        console.log(res)
                    }
                });
            });

        });
    </script>
@endsection
@extends('.common.index')


@section('content')
    {{--{{ gettype($class_info) }}--}}

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="stu_grade">导入学生成绩</input>
        <select name="class_no">
            <option>--请选择班级--</option>
            @foreach($class_info as $cInfo)
                <option value="{{ $cInfo->class_no }}">{{ $cInfo->class_no }}</option>
            @endforeach
        </select>
    </form>

    <h2>学生成绩</h2>

@endsection
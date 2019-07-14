@extends('.common.index')

@section('content')

    <a href="{{ url('user/add_test_describe') }}"><button class="layui-btn layui-btn-primary">添加考试描述</button></a>
    <table class="layui-table">
    <colgroup>
    <col width="150">
    <col width="200">
    <col>
    </colgroup>
    <thead>
    <tr>
    <th>时间</th>
    <th>考试描述</th>
    </tr>
    </thead>
    <tbody>
    @if($data != '')
        @foreach($data as $val)
            <tr>
            <td>{{ substr($val->test_date, 0, 10) }}</td>
            <td>{{ $val->describe }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    </table>

@endsection
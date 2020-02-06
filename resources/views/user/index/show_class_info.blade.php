@extends('.common.index')

@section('content')
    <table class="table table-hover">
    <colgroup>
    <col width="150">
    <col width="200">
    <col>
    </colgroup>
    <thead>
    <tr>
    <th>班级</th>
    <th>班主任</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $val)
        <tr>
        <td>{{ $val->class_no }}</td>
        <td>{{ $val->manager }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    <a href="{{ url('user/add_classinfo') }}"><button style="margin-left: 5px;" class="btn btn-primary">添加班级</button></a>
@endsection
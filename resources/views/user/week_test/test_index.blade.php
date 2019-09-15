@extends('.common.index')

@section('content')

    <h2>这是周测生成页面</h2>
    <a href="{{ url('user/create_test') }}"><h3>导出成word文档</h3></a>

@endsection
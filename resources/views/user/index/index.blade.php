@include('.common.head')
@include('.common.left_menu')
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    @section('content')
                    @endsection
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('css/layui/layui.js') }}"></script>
@include('.common.foot')
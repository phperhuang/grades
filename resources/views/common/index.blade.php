@include('.common.head')
@include('.common.left_menu')
<!-- 右侧内容 -->
<div class="layui-body layui-form">
    <div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">
        <div class="layui-tab-content clildFrame">
            <div class="layui-tab-item layui-show">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('.common.foot')
@include('.common.head')
@include('.common.left_menu')

<?php
    if(session()->get())

?>

{{--<!-- 右侧内容 -->--}}
{{--<div class="layui-body layui-form">--}}
    {{--<div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">--}}
        {{--<div class="layui-tab-content clildFrame">--}}
            {{--<div class="layui-tab-item layui-show">--}}
                {{--@yield('content')--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<section id="main-content">
    <section class="wrapper">
        <div class="row">

            @yield('content')

            <!-- /col-lg-9 END SECTION MIDDLE -->
            <!-- **********************************************************************************************************************************************************
                RIGHT SIDEBAR CONTENT
                *********************************************************************************************************************************************************** -->

            <!-- /col-lg-3 -->
        </div>
        <!-- /row -->
    </section>
</section>



@include('.common.foot')
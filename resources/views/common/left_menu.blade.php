<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered"><a href="profile.html"><img src="{{ url('images/img/ui-sam.jpg') }}" class="img-circle" width="80"></a></p>
            <h5 class="centered">姓名</h5>
            <li class="mt">
                <a class="" href="{{ url('user/class_list') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>班级信息</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/entering_grades') }}">
                    <i class="fa fa-desktop"></i>
                    <span>录入成绩</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/show_grades') }}">
                    <i class="fa fa-cogs"></i>
                    <span>成绩显示</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/test_describe_list') }}">
                    <i class="fa fa-book"></i>
                    <span>考试列表</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/test_index') }}">
                    <i class="fa fa-tasks"></i>
                    <span>生成周测</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/stu_grade') }}">
                    <i class="fa fa-th"></i>
                    <span>学生成绩</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/get_student_all_grades') }}">
                    <i class="fa fa-th"></i>
                    <span>学生变化表</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/dztm_index') }}">
                    <i class="fa fa-th"></i>
                    <span>导出德智体美表</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{ url('user/expload_dztm') }}">
                    <i class="fa fa-th"></i>
                    <span>导出德智体美表123</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>

<!--main content end-->
<!--footer start-->
{{--<footer class="site-footer">--}}

{{--</footer>--}}
<!--footer end-->
</section>
<!-- js placed at the end of the document so the pages load faster -->
{{--<script src="{{ url('lib/jquery/jquery.min.js') }}"></script>--}}

<script class="include" type="text/javascript" src="{{ url('lib/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ url('lib/jquery.scrollTo.min.js') }}"></script>
<script src="{{ url('lib/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ url('lib/jquery.sparkline.js') }}"></script>
<!--common script for all pages-->
<script src="{{ url('lib/common-scripts.js') }}"></script>
<script type="text/javascript" src="{{ url('lib/gritter/js/jquery.gritter.js') }}"></script>
<script type="text/javascript" src="{{ url('lib/gritter-conf.js') }}"></script>
<!--script for this page-->
<script src="{{ url('lib/sparkline-chart.js') }}"></script>
<script src="{{ url('lib/zabuto_calendar.js') }}"></script>

<script type="text/javascript">
    // 点击的时候，就给该 a 标签一个 active 的 class
    $(function () {

    })
</script>

</body>

</html>
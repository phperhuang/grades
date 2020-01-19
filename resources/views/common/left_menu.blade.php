<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main mag0">
            <a href="#" class="logo">layuiCMS 2.0</a>
            <!-- 显示/隐藏菜单 -->
        {{--<a href="javascript:;" class="seraph hideMenu icon-caidan"></a>--}}
        <!-- 顶级菜单 -->
            <ul class="layui-nav mobileTopLevelMenus" mobile>
                <li class="layui-nav-item" data-menu="contentManagement">
                    <a href="javascript:;"><i class="seraph icon-caidan"></i><cite>layuiCMS</cite></a>
                    <dl class="layui-nav-child">
                        <dd class="layui-this" data-menu="contentManagement"><a href="{{ url('user/add_classinfo') }}"><i class="layui-icon" data-icon="&#xe63c;">&#xe63c;</i><cite>录入班级</cite></a></dd>
                        <dd data-menu="memberCenter"><a href="{{ url('user/entering_grades') }}"><i class="layui-icon" data-icon="&#xe63c;">&#xe63c;</i><cite>录入成绩</cite></a></dd>
                        <dd data-menu="systemeSttings"><a href="{{ url('user/show_grades') }}"><i class="layui-icon" data-icon="&#xe620;">&#xe620;</i><cite>成绩显示</cite></a></dd>
                        <dd data-menu="systemeSttings"><a href="{{ url('user/test_describe_list') }}"><i class="layui-icon" data-icon="&#xe620;">&#xe620;</i><cite>考试列表</cite></a></dd>
                        {{--<dd data-menu="seraphApi"><a href="javascript:;"><i class="layui-icon" data-icon="&#xe705;">&#xe705;</i><cite>使用文档</cite></a></dd>--}}
                    </dl>
                </li>
            </ul>

            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item" id="userInfo">
                    <a href="javascript:;"><img src="{{ url('images/userface1.jpg') }}" class="layui-nav-img userAvatar" width="35" height="35"><cite class="adminName">班主任</cite></a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="seraph icon-ziliao" data-icon="icon-ziliao"></i><cite>个人资料</cite></a></dd>
                        <dd><a href="javascript:;" data-url="page/user/changePwd.html"><i class="seraph icon-xiugai" data-icon="icon-xiugai"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="javascript:;" class="showNotice"><i class="layui-icon">&#xe645;</i><cite>系统公告</cite></a></dd>
                        <dd pc><a href="javascript:;" class="functionSetting"><i class="layui-icon">&#xe620;</i><cite>功能设定</cite></a></dd>
                        <dd pc><a href="javascript:;" class="changeSkin"><i class="layui-icon">&#xe61b;</i><cite>更换皮肤</cite></a></dd>
                        <dd><a href="{{ url('/user/logout') }}" class="signOut"><i class="seraph icon-tuichu"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <div class="user-photo">
            <a class="img" title="我的头像" ><img src="{{ url('images/userface1.jpg') }}" class="userAvatar"></a>
        </div>
        <!-- 搜索 -->
        <div class="layui-form component">
            <select name="search" id="search" lay-search lay-filter="searchPage">
                <option value="">搜索页面或功能</option>
                <option value="1">layer</option>
                <option value="2">form</option>
            </select>
            <i class="layui-icon">&#xe615;</i>
        </div>
        <div class="navBar layui-side-scroll" id="navBar">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
{{--                    <a href="{{ url('user/add_classinfo') }}"><i class="layui-icon" data-icon=""></i><cite>班级信息</cite></a>--}}
                    <a href="{{ url('user/class_list') }}"><i class="layui-icon" data-icon=""></i><cite>班级信息</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ url('user/entering_grades') }}"><i class="layui-icon" data-icon=""></i><cite>录入成绩</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ url('user/show_grades') }}"><i class="layui-icon" data-icon=""></i><cite>成绩显示</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ url('user/test_describe_list') }}"><i class="layui-icon" data-icon=""></i><cite>考试列表</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ url('user/test_index') }}"><i class="layui-icon" data-icon=""></i><cite>生成周测</cite></a>
                </li>
                {{-- test_describe_list --}}
                <li class="layui-nav-item">
                    <a href="{{ url('user/parents_sign') }}"><i class="layui-icon" data-icon=""></i><cite>家长会签到</cite></a>
                </li>

                <li class="layui-nav-item">
                    <a href="{{ url('user/stu_grade') }}"><i class="layui-icon" data-icon=""></i><cite>学生成绩</cite></a>
                </li>

            </ul>
        </div>
    </div>

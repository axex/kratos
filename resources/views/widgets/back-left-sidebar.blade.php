<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : '/avatar/default.png' }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->realname ? Auth::user()->realname : Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">主导航栏</li>

            <!--控制台 active treeview-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>控制面板</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-circle-o"></i> 概述</a></li>
                    <li><a href="{{ route('dashboard.me') }}"><i class="fa fa-circle-o"></i> 个人资料</a></li>
                </ul>
            </li>
            <!--/.控制台 active treeview-->

            <!--内容管理 treeview-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>内容管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dashboard.issue.index') }}"><i class="fa fa-circle-o"></i> 期数</a></li>
                    <li><a href="{{ route('dashboard.article.index') }}"><i class="fa fa-circle-o"></i> 文章</a></li>
                    <li><a href="{{ route('dashboard.submission.index') }}"><i class="fa fa-circle-o"></i> 投稿</a></li>
                    <li><a href="{{ route('dashboard.category.index') }}"><i class="fa fa-circle-o"></i> 分类</a></li>
                </ul>
            </li>
            <!--/.内容管理 treeview-->

            <!--无子节点的一级导航节点-->
            {{--<li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>写作</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-tags"></i> <span>标签</span></a></li>--}}

            {{--<!--讨论 treeview-->--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class='fa fa-comments-o'></i>--}}
                    {{--<span>讨论</span>--}}
                    {{--<small class="label pull-right bg-green">New</small>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="#"><i class="fa fa-square-o"></i>节点</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-square-o"></i>话题</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-square-o"></i>审核</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-square-o"></i>举报</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-square-o"></i>论友</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<!--/.讨论 treeview-->--}}

            <!--用户管理 treeview-->
            <li class="treeview">
                <a href="#"><i class='fa fa-user'></i>
                    <span>用户管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dashboard.user.index') }}"><i class="fa fa-circle-o"></i>后台用户</a></li>
                    <li><a href="{{ route('dashboard.subscribe.index') }}"><i class="fa fa-circle-o"></i>订阅用户</a></li>
                    <li><a href="{{ route('dashboard.role.index') }}"><i class="fa fa-circle-o"></i>角色</a></li>
                    <li><a href="{{ route('dashboard.permission.index') }}"><i class="fa fa-circle-o"></i>权限</a></li>
                </ul>
            </li>
            <!--/.用户管理 treeview-->

            <!--业务管理 treeview-->
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class='fa fa-coffee'></i>--}}
                    {{--<span>业务管理</span>--}}
                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="#"><i class="fa fa-sitemap"></i>业务流程</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-envelope-o"></i>信息 <span class="label label-success pull-right">4</span></a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-bell-o"></i>通知 <span class="label label-warning pull-right">10</span></a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-flag-o"></i>任务 <span class="label label-danger pull-right">9</span></a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <!--/.业务管理 treeview-->

            <!--系统管理 treeview-->
            <li class="treeview">
                <a href="#"><i class='fa fa-cog'></i>
                    <span>系统管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dashboard.system.setting') }}"><i class="fa fa-square-o"></i>系统配置</a></li>
                    <li><a href="{{ route('dashboard.system.log.index') }}"><i class="fa fa-square-o"></i>系统日志</a></li>
                </ul>
            </li>
            <!--/.系统管理 treeview-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
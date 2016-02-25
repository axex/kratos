<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('backend.console') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>K</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Kratos</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fa fa-home" title="前台首页"></i>
                        <span class="label label-info">H</span>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : '/avatar/default.png' }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->realname ? Auth::user()->realname : Auth::user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : '/avatar/default.png' }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::user()->realname ? Auth::user()->realname : Auth::user()->username }} - {{ Auth::user()->role }}
                                <small>{{ Auth::user()->created_at->toDateString() }} 加入</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">消息</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">任务</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">好友</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('backend.me') }}" class="btn btn-default btn-flat">个人资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
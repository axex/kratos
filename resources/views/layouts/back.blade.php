@extends('layouts.base')

@section('title') 后台 @stop

@section('meta')
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@stop

@section('head_css')
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/ionicons/css/ionicons.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/kratos.css') }}">
@stop

@section('head_js')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/html5shiv/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets/respond/respond.min.js') }}"></script>
    <![endif]-->
@stop

@section('body_attr') class="hold-transition skin-blue sidebar-mini" @stop

@section('body')
    <!--检查是否启用JavaScript脚本-->
    <noscript>
        <style type="text/css">
            .noscript{ width:100%;height:100%;overflow:hidden;background:#000;color:#fff;position:absolute;z-index:99999999; background-color:#000;opacity:1.0;filter:alpha(opacity=100);margin:0 auto;top:0;left:0;}
            .noscript h1{font-size:36px;margin-top:50px;text-align:center;line-height:40px;}
            html {overflow-x:hidden;overflow-y:hidden;}/*禁止出现滚动条*/
        </style>
        <div class="noscript">
            <h1>
                您的浏览器不支持JavaScript，请启用后重试！
            </h1>
        </div>
    </noscript>
    <div class="wrapper">

        @include('widgets.back-header')

        @include('widgets.back-left-sidebar')

                <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @section('content-header')
                    {{--内容头部区域--}}
                @show
            </section>

            <!-- Main content -->
            <section class="content">
                @section('content')
                    {{--内容主体区域--}}
                @show
            </section>
            <!-- /.content -->
        </div>

        @include('widgets.back-footer')

        @include('widgets.back-right-sidebar')
    </div>
    <!-- ./wrapper -->

    @section('afterBody')
        <!-- jQuery 2.1.4 -->
        <script src="{{ asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/dist/js/app.min.js') }}"></script>
        <!-- AdminLTE Demo -->
        <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

        @section('extraPlugin')
            {{-- 引入额外依赖JS插件 --}}
        @show

        <script type="text/javascript">
            $(document).ready(function(){
                <!--highlight main-sidebar-->
                $('ul.treeview-menu>li').find('a[href="{{ currentNav(Route::currentRouteName()) }}"]').closest('li').addClass('active');  //二级链接高亮
                $('ul.treeview-menu>li').find('a[href="{{ currentNav(Route::currentRouteName()) }}"]').closest('li.treeview').addClass('active');  //一级栏目[含二级链接]高亮
                $('.sidebar-menu>li').find('a[href="{{ currentNav(Route::currentRouteName()) }}"]').closest('li').addClass('active');  //一级栏目[不含二级链接]高亮
            });
            @section('filledScript')
            @show{{-- 在document ready 里面填充一些JS代码 --}}
        </script>
    @stop
@stop
@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        控制面板
        <small>个人资料</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">控制面板 - 个人资料</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">修改个人资料</h3>
            <p>以下为您作为当前用户的个人资料，您仅可修改个人头像、真实姓名与登录密码。登录密码项留空，则不修改登录密码。</p>
            <div class="basic_info bg-info">
                <ul>
                    <li>登录名：<span class="text-primary">{{ Auth::user()->username }}</span></li>
                    <li>真实姓名：<span class="text-primary">{{ Auth::user()->realname }}</span></li>
                    <li>电子邮件：<span class="text-primary">{{ Auth::user()->email }}</span></li>
                </ul>
            </div>
        </div><!-- /.box-header -->
        <div class="col-md-6">
            <form id="setting-form" method="post" action="{{ route('dashboard.me') }}" accept-charset="utf-8">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>邮箱 <small class="text-red">*</small></label>
                        <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="邮箱">
                    </div>
                    <div class="form-group">
                        <label>真实姓名</label>
                        <input type="text" class="form-control" name="realname" value="{{ Auth::user()->realname }}" placeholder="真实姓名">
                    </div>
                    <div class="form-group">
                        <label>登录密码</label>
                        <input type="password" class="form-control" name="password" value="" autocomplete="off"
                               placeholder="登录密码">
                    </div>
                    <div class="form-group">
                        <label>确认登录密码</label>
                        <input type="password" class="form-control" name="password_confirmation" value=""
                               autocomplete="off" placeholder="登录密码">
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">修改个人资料</button>
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <form method="post" action="{{ route('dashboard.avatar') }}" enctype="multipart/form-data" id="upload-form">
                <div class="box-body">
                    <div class="form-group avatar-group">
                        <img class="img-circle" id="user-avatar" src="{{ Auth::user()->avatar ? Auth::user()->avatar : '/avatar/default.png' }}" alt="头像">
                        <a class="btn btn-position btn-default" href="javascript:;">
                        {{ csrf_field() }}
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                        <span id="uploading">上传头像</span>
                        </a>
                        <p class="text-muted">支持 2MB 以内的 PNG / JPG / GIF 等格式图片</p>
                    </div>
                    <div id="validation-errors"></div>
                    <div id="output"></div>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop

@section('extraPlugin')
    <script type="text/javascript" src="{{ asset('assets/plugins/jQueryFormPlugin/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/js/kratos.js') }}"></script>
@stop
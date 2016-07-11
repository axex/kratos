@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        用户管理
        <small>角色</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{ route('dashboard.role.index') }}">用户管理 - 角色</a></li>
        <li class="active">修改角色</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <h2 class="page-header">修改角色</h2>
    <form method="post" action="{{ route('dashboard.role.update', $role->id) }}" accept-charset="utf-8">
        {{ method_field('put') }}
        {{ csrf_field() }}
        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab_1">
                    <div class="form-group">
                        <label>角色(用户组)名 <small class="text-red">*</small>  <span class="text-green small">只能为英文单词，建议首字母大写</span></label>
                        <input type="text" class="form-control" name="name" value="{{ $role->name }}" placeholder="角色(用户组)名">
                    </div>
                    <div class="form-group">
                        <label>角色(用户组)展示名 <small class="text-red">*</small> <span class="text-green small">展示名可以为中文</span></label>
                        <input type="text" class="form-control" name="display_name" value="{{ $role->display_name }}" placeholder="角色(用户组)展示名">
                    </div>
                    <div class="form-group">
                        <label>角色(用户组)描述</label>
                        <textarea class="form-control" name="description" cols="45" rows="2" maxlength="200" placeholder="角色(用户组)描述" autocomplete="off">{{ $role->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>关联权限</label>
                        <div class="input-group">
                            @foreach($permissions as $permission)
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                @if(in_array($permission->id, $ownPermissions))
                                    {{ "checked" }}
                                @endif
                                >
                                <label class="choice" for="permissions[]">{{ $permission->display_name }}</label>
                            @endforeach
                        </div>
                    </div>
                </div><!-- /.tab-pane -->

                <button type="submit" class="btn btn-primary">修改角色</button>

            </div><!-- /.tab-content -->

        </div>
    </form>

    @stop

    @section('extraPlugin')

            <!--引入iCheck组件-->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

    @stop


    @section('filledScript')
            <!--启用iCheck响应checkbox与radio表单控件-->
    $('input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    increaseArea: '20%' // optional
    });
@stop

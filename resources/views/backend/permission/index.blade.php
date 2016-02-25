@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        用户管理
        <small>权限</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">用户管理 - 权限</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">权限列表</h3>
            <div class="box-tips clearfix">
                <p><b>权限影响系统安全与稳定，错误或不合理的修改可能会影响系统业务与逻辑，故在此屏蔽掉权限 增、删、改 功能。</b></p>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>操作</th>
                    <th>编号</th>
                    <th>权限标识串</th>
                    <th>权限展示名</th>
                    <th>创建日期</th>
                    <th>更新日期</th>
                </tr>
                <!--tr-th end-->

                @foreach ($permissions as $permission)
                    <tr>
                        <td> - </td>
                        <td>{{ $permission->id }}</td>
                        <td class="text-green">{{ $permission->name }}</td>
                        <td class="text-red">{{ $permission->display_name }}</td>
                        <td>{{ $permission->created_at }}</td>
                        <td>{{ $permission->updated_at }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
@stop


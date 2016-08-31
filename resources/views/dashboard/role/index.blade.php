@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        用户管理
        <small>角色</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">用户管理 - 角色</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <a href="{{ route('dashboard.dashboard.role.create') }}" class="btn btn-primary margin-bottom">新增角色</a>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">角色列表</h3>
            <div class="box-tips clearfix">
                <p class="text-red">
                    请在超级管理员协助下完成新增修改与删除角色（用户组）操作。
                </p>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>操作</th>
                    <th>编号</th>
                    <th>角色（用户组）名</th>
                    <th>角色展示名</th>
                    <th>创建日期</th>
                    <th>更新日期</th>
                </tr>
                <!--tr-th end-->

                @foreach ($roles as $role)
                    <tr>
                        <td>
                            <a href="{{ route('dashboard.dashboard.role.index') }}/{{ $role->id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-link" title="预览"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-minus-circle delete_item" title="删除" data-id="{{ $role->id }}"></i></a>
                        </td>
                        <td class="text-muted">{{ $role->id }}</td>
                        <td class="text-green">{{ $role->name }}</td>
                        <td class="text-red">{{ $role->display_name }}</td>
                        <td>{{ $role->created_at }}</td>
                        <td>{{ $role->updated_at }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div><!-- /.box-body -->

        <!--隐藏型删除表单-->
        <form method="post" action="{{ route('dashboard.dashboard.role.destroy') }}" accept-charset="utf-8" id="hidden-delete-form">
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </form>

    </div>
    @stop


    @section('filledScript')
            <!--jQuery 提交表单，实现DELETE删除资源-->
    //jQuery submit form
    $('.delete_item').click(function(){
    var action = '{{ route('dashboard.dashboard.role.index') }}';
    var id = $(this).data('id');
    var new_action = action + '/' + id;
    $('#hidden-delete-form').attr('action', new_action);
    if(confirm('确认删除此角色？')) {
        $('#hidden-delete-form').submit();
    }
    });
@stop

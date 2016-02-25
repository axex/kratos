@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        用户管理
        <small>管理员</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">用户管理 - 管理员</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <a href="{{ route('backend.user.create') }}" class="btn btn-primary margin-bottom">新增管理员</a>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">管理员列表</h3>
            <div class="box-tools">
                <form action="{{ route('backend.user.index') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="s_name" value="{{ Input::get('s_name') }}" style="width: 180px;" placeholder="搜索用户登录名或真实姓名">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>操作</th>
                    <th>编号</th>
                    <th>登录名</th>
                    <th>真实姓名</th>
                    <th>角色(用户组)</th>
                    <th>状态</th>
                    <th>最后一次登录时间</th>
                </tr>
                <!--tr-th end-->
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('backend.user.edit', $user->id) }}"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-minus-circle delete_item" title="删除" data-toggle="modal" data-id="{{ $user->id }}"></i></a>
                        </td>
                        <td>{{ $user->id }}</td>
                        <td class="text-muted">{{ $user->username }}</td>
                        <td class="text-green">{{ $user->realname }}</td>
                        <td class="text-red">
                            @if ($user->roles()->first())
                                {{ $user->roles()->first()->display_name }}
                            @endif
                        </td>

                            @if($user->is_lock)
                                <td class="text-yellow">锁定</td>
                            @else
                                <td class="text-danger">正常</td>
                            @endif

                        <td>{{ $user->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $users->appends(['s_name' => Input::get('s_name')])->render() !!}
        </div>

        <!--隐藏型删除表单-->
        <form method="post" action="" accept-charset="utf-8" id="hidden-delete-form">
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </form>
    </div>
    @stop


    @section('filledScript')
    <!--jQuery 提交表单，实现DELETE删除资源-->
    $('.delete_item').click(function(){
    var action = '{{ route('backend.user.index') }}';
    var id = $(this).data('id');
    var new_action = action + '/' + id;
    $('#hidden-delete-form').attr('action', new_action);
    if(confirm('确认删除此用户？')) {
        $('#hidden-delete-form').submit();
    }
    });

@stop

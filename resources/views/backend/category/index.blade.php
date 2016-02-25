@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        内容管理
        <small>分类</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">内容管理 - 分类</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <a href="{{ route('backend.category.create') }}" class="btn btn-primary margin-bottom">新增分类</a>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">分类列表</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>名称</th>
                    <th>操作</th>
                    <th>缩略名</th>
                    <th>文章数</th>
                </tr>
                <!--tr-th end-->

                @foreach ($categories as $cat)
                    <tr>
                        <td class="text-muted">{{ $cat->name }}</td>
                        <td>
                            <a href="{{ route('backend.category.index') }}/{{ $cat->id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-link" title="查看"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-minus-circle delete_item" title="删除" data-toggle="modal" data-show-count="{{ count( $cat->articles ) }}" data-id="{{ $cat->id }}"></i></a>
                        </td>
                        <td class="text-green">{{ $cat->slug }}</td>
                        <td class="text-red">{{ count( $cat->articles()->get() ) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div><!-- /.box-body -->

        {!! $categories->render() !!}

        <!--隐藏型删除表单-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('backend.category.destroy') }}" method="post" accept-charset="utf-8" id="hidden-delete-form">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">提示</h4>
                        </div>
                        <div class="modal-body">
                            该分类下有 <span id="show-count"></span> 篇文章, 删除该分类会把该分类下的文章也一并删除
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary btn-danger">确定</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @stop


    @section('filledScript')
    <!--jQuery 提交表单，实现DELETE删除资源-->
    $('.delete_item').click(function(){
    var action = '{{ route('backend.category.index') }}';
    var id = $(this).data('id');
    var count = $(this).data('show-count');
    var new_action = action + '/' + id;
    $(this).attr('data-target', '#myModal');
    $('#show-count').html(count);
    $('#hidden-delete-form').attr('action', new_action);
    });

@stop

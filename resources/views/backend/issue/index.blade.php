@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        内容管理
        <small>期数</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">内容管理 - 期数</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <a href="{{ route('backend.issue.create') }}" class="btn btn-primary margin-bottom">新增期数</a>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">期数列表</h3>
            <div class="box-tools">
                <form action="{{ route('backend.issue.index') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="kword"
                               value="{{ Input::get('kword') }}" style="width: 150px;" placeholder="搜索期数">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-tips clearfix">
                <p>
                    未发布期数的发布日期显示为<span class="text-red">红色</span>, 已经发布的发布日期显示为<span class="text-green">绿色</span>
                </p>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <div class="tablebox-controls">
                <!-- Check all button -->
                <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o" title="全选/反全选"></i></button>
                <button class="btn btn-default btn-sm" id="batch-delete" data-toggle="modal" onclick="batchDelete()"><i class="fa fa-trash-o" title="删除"></i></button>
                <button class="btn btn-default btn-sm" id="refresh"><i class="fa fa-refresh" title="刷新"></i></button>
            </div>
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>选择</th>
                    <th>操作</th>
                    <th>期数</th>
                    <th>文章数</th>
                    <th>发布日期</th>
                </tr>
                <!--tr-th end-->

                @foreach ($issues as $issue)
                    <tr>
                        <td class="table-operation">
                            <input type="checkbox" value="{{ $issue->id }}" name="checkbox">
                        </td>
                        <td>
                            <a href="{{ route('backend.issue.edit', $issue->id) }}"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-link" title="预览"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-minus-circle delete_item" title="删除" data-toggle="modal" data-show-count="{{ count( $issue->articles()->get() ) }}" data-id="{{ $issue->id }}"></i></a>
                        </td>
                        <td class="text-muted">{{ $issue->issue }}</td>
                        <td class="text-black">{{ count($issue->articles) }}</td>
                        <td class="{{ $issue->published_at > \Carbon\Carbon::now() ? 'text-red' : 'text-green' }}">{{ $issue->published_at }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $issues->appends(['kword' => Input::get('kword')])->render() !!}
        </div>

        <!--隐藏型删除表单-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('backend.issue.delete') }}" method="post" accept-charset="utf-8" id="hidden-delete-form">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="checkedList" id="checkedList">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">提示</h4>
                        </div>
                        <div class="modal-body">
                            删除期数也会把对应期数下的文章也一并删除
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

    @section('extraPlugin')
            <!--引入iCheck组件-->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    @stop

    @section('filledScript')
    <!--启用iCheck响应checkbox与radio表单控件-->
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.table-operation input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
    var clicks = $(this).data('clicks');
    if (clicks) {
    //Uncheck all checkboxes
    $(".table-operation input[type='checkbox']").iCheck("uncheck");
    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
    } else {
    //Check all checkboxes
    $(".table-operation input[type='checkbox']").iCheck("check");
    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
    }
    $(this).data("clicks", !clicks);
    });

    <!--jQuery 提交表单，实现DELETE删除单篇文章-->
    $('.delete_item').click(function(){
    var id = $(this).data('id');
    var action = '{{ route('backend.issue.index') }}';
    var new_action = action + '/' + id;
    $(this).attr('data-target', '#myModal');
    $('#hidden-delete-form').attr('action', new_action);
    });


    <!-- 删除多篇文章 -->
    function batchDelete() {
    var checkedNum = $("input[name='checkbox']:checked").length;
    if (checkedNum == 0) {
    alert('请至少选择一项');
    return;
    }
    $('#batch-delete').attr('data-target', '#myModal');
    var checkedList = new Array();
    $("input[name='checkbox']:checked").each(function () {
    checkedList.push($(this).val());
    });
    $('#checkedList').val(checkedList);
    }

    <!-- 刷新页面 -->
    $('#refresh').click(function() {
    location.reload();
    });

@stop

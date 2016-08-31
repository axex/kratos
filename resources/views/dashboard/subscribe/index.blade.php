@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        用户管理
        <small>订阅用户</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">用户管理 - 订阅用户</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <div class="box box-primary">
        <div class="box-body table-responsive">
            <div class="tablebox-controls">
                <!-- Check all button -->
                <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o" title="全选/反全选"></i></button>
                <button class="btn btn-default btn-sm" id="batch-delete" data-toggle="modal" onclick="batchDelete()"><i class="fa fa-trash-o" title="删除"></i></button>
                <button class="btn btn-default btn-sm" id="refresh"><i class="fa fa-refresh" title="刷新"></i></button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('dashboard.subscribe.delete') }}" method="post" accept-charset="utf-8" id="batch-delete-form">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="checkedList" id="checkedList">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">提示</h4>
                                </div>
                                <div class="modal-body">
                                    确认删除所选项目？
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
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>选择</th>
                    <th>操作</th>
                    <th>名字</th>
                    <th>邮箱</th>
                    <th>激活</th>
                    <th>订阅时间</th>
                </tr>
                <!--tr-th end-->

                @foreach ($subscribes as $subscribe)
                    <tr>
                        <td class="table-operation">
                            <input type="checkbox" value="{{ $subscribe->id }}" name="checkbox">
                        </td>
                        <td>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-minus-circle delete_item" title="删除" data-id="{{ $subscribe->id }}"></i></a>
                        </td>
                        <td class="text-muted">{{ str_limit($subscribe->name, 50) }}</td>
                        <td class="text-orange">{{ $subscribe->email }}</td>
                        @if($subscribe->is_confirmed == 0)
                            <td class="text-red">否</td>
                        @else
                            <td class="text-green">是</td>
                        @endif
                        <td>{{ $subscribe->created_at }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $subscribes->render() !!}
        </div>

        <!--隐藏型删除表单-->

        <form method="post" action="" accept-charset="utf-8" id="hidden-delete-form">
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </form>

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
    var action = '{{ route('dashboard.dashboard.subscribe.index') }}';
    var new_action = action + '/' + id;
    $('#hidden-delete-form').attr('action', new_action);
    $('#hidden-delete-form').submit();
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

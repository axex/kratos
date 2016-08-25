@extends('layouts.back')

@section('content-header')
  @parent
  <h1>
    系统管理
    <small>系统日志</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
    <li class="active">系统管理 - 系统日志</li>
  </ol>
@stop

@section('content')

  @include('widgets.back-content-alert')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">日志列表</h3>
      <div class="box-tools">
        <form action="{{ route('dashboard.system.log.index') }}" method="get">
          <div class="input-group">
            <input type="text" class="form-control input-sm pull-right" name="s_username"
                   value="{{ Input::get('s_username') }}" style="width: 150px;" placeholder="搜索操作者">
            <input type="text" class="form-control input-sm pull-right" name="s_ip" value="{{ Input::get('s_ip') }}"
                   style="width: 150px;" placeholder="搜索操作者IP">
            <div class="input-group-btn">
              <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
      <div class="tablebox-controls">
        <a href="{{ route('dashboard.export.excel') }}" class="btn btn-default btn-sm"><i class="fa fa-file-excel-o"
                                                                                          title="导出为excel文件"></i></a>
      </div>
      <table class="table table-hover table-bordered">
        <tbody>
        <!--tr-th start-->
        <tr>
          <th>查阅</th>
          <th>操作者</th>
          <th>操作者IP</th>
          <th>操作URL</th>
          <th>操作内容</th>
          <th>操作时间</th>
        </tr>
        <!--tr-th end-->

        @foreach ($logs as $log)
          <tr>
            <td>
              <a href="{{ route('dashboard.system.log.show', $log->id) }}"><i class="fa fa-fw fa-link"
                                                                              title="预览"></i></a>
            </td>
            <td class="text-green">{{ $log->user->username }}</td>
            <td class="text-yellow">{{ $log->operator_ip }}</td>
            <td class="overflow-hidden" title="{{ $log->url }}">{{ $log->url }}</td>
            <td class="overflow-hidden text-red"
                title="{{ $log->content }}">{{ str_limit($log->content, 70, '...') }}</td>
            <td>{{ $log->created_at }}</td>
          </tr>
        @endforeach

        </tbody>
      </table>
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
      {!! $logs->appends(['s_username' => Input::get('s_username'), 's_ip' => Input::get('s_ip')])->render() !!}
    </div>
  </div>
@stop


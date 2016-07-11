@extends('layouts.back')

@section('head_css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery.cxcalendar-1.5/css/jquery.cxcalendar.css') }}">
@stop

@section('content-header')
    @parent
    <h1>
        内容管理
        <small>期数</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{ route('dashboard.article.index') }}">内容管理 - 期数</a></li>
        <li class="active">新增期数</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <h2 class="page-header">新增期数</h2>
    <form method="post" action="{{ route('dashboard.issue.store') }}" accept-charset="utf-8">
        {{ csrf_field() }}
        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="form-group">
                        <label>期数 <small class="text-red">*</small></label>
                        <input type="text" class="form-control" name="issue" value="{{ old('issue') }}" placeholder="期数">
                    </div>
                    <div class="form-group">
                        <label>发布日期</label>
                        <input type="text" id="date" class="form-control" name="published_at" value="{{ old('published_at') }}" readonly placeholder="发布日期, 不填为立即发布">
                    </div>
                </div><!-- /.tab-pane -->

                <button type="submit" class="btn btn-primary">新增期数</button>
            </div><!-- /.tab-content -->

        </div>
    </form>
    @stop

    @section('extraPlugin')
        <!-- 引入日期选择器 -->
    <script src="{{ asset('assets/plugins/jquery.cxcalendar-1.5/js/jquery.cxcalendar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery.cxcalendar-1.5/js/jquery.cxcalendar.languages.js') }}" type="text/javascript"></script>
    @include('widgets.endChosen')
    @stop

    @section('filledScript')
    $.cxCalendar.defaults.startDate = '{{ \Carbon\Carbon::now()->toDateString() }}';
    $.cxCalendar.defaults.type = 'datetime';
    $.cxCalendar.defaults.baseClass = 'cxcalendar_holyday';
    $.cxCalendar.defaults.format = 'YYYY-MM-DD HH:mm:ss';
    $('#date').cxCalendar();
    @stop
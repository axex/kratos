@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{ route('dashboard.dashboard.article.index') }}">内容管理 - 文章</a></li>
        <li class="active">撰写新文章</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <h2 class="page-header">撰写新文章</h2>
    <form method="post" action="{{ route('dashboard.dashboard.article.store') }}" accept-charset="utf-8">
        {{ csrf_field() }}
        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="form-group">
                        <label>标题 <small class="text-red">*</small></label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="标题">
                    </div>
                    <div class="form-group">
                        <label>外链地址 <small class="text-red">*</small></label>
                        <input type="text" class="form-control" name="url" value="{{ old('url') }}" placeholder="http://example.com/">
                    </div>
                    <div class="form-group">
                        <label>关键词</label>
                        <input type="text" class="form-control" name="tags" value="{{ old('tags') }}" placeholder="(多个请用','隔开)">
                    </div>
                    <div class="form-group">
                        <label>推荐者</label>
                        <input type="text" class="form-control" name="presenter" value="{{ old('presenter') }}" placeholder="推荐者">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label>期数 <small class="text-red">*</small></label>
                                <div class="input-group">
                                    <select data-placeholder="选择期数..." class="chosen-select" style="min-width:200px;" name="issue">
                                        @foreach($issues as $issue)
                                            <option value="{{ $issue->issue }}">第 {{ $issue->issue }} 期</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>分类 <small class="text-red">*</small></label>
                                <div class="input-group">
                                    <select data-placeholder="选择文章分类..." class="chosen-select" style="min-width:200px;" name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>简介 <small class="text-red">*</small></label>
                        <textarea id="container" name="desc">{{ old('desc') }}</textarea>
                        @include('vendor.ueditor.assets'){{-- 引入 ueditor 编辑器相关JS依赖 --}}
                    </div>
                </div><!-- /.tab-pane -->

                <button type="submit" class="btn btn-primary">发布文章</button>

            </div><!-- /.tab-content -->

        </div>
    </form>
    @stop

    @section('extraPlugin')
        <!--引入iCheck组件-->
        <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
        @include('widgets.endChosen')
    @stop

    @section('filledScript')
        <!--启用iCheck响应checkbox与radio表单控件-->
        $('input[type="radio"]').iCheck({
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%' // optional
        });
        $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        increaseArea: '20%' // optional
        });
    @stop
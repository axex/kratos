@extends('layouts.back')

@section('content-header')
    @parent
    <h1>
        内容管理
        <small>分类</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{ route('dashboard.dashboard.category.index') }}">内容管理 - 分类</a></li>
        <li class="active">修改分类</li>
    </ol>
@stop

@section('content')

    @include('widgets.back-content-alert')

    <h2 class="page-header">修改分类</h2>
    <form method="post" action="{{ route('dashboard.dashboard.category.update', $category->id ) }}" accept-charset="utf-8">
        {{ method_field('put') }}
        {{ csrf_field() }}

        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab_1">
                    <div class="form-group">
                        <label>分类名称 <small class="text-red">*</small> <span class="text-green small">简短为宜</span></label>
                        <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="分类名称" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label>分类缩略名 <span class="text-green small">只能是字母或数字</span></label>
                        <input type="text" class="form-control" name="slug" value="{{ $category->slug }}" placeholder="分类缩略名" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label>分类描述 <span class="text-green small">建议百字以内，有助于网站SEO</span></label>
                        <textarea class="form-control" name="desc" cols="45" rows="2" maxlength="200" placeholder="分类描述">{{ $category->desc }}</textarea>
                    </div>
                </div><!-- /.tab-pane -->

                <button type="submit" class="btn btn-primary">修改分类</button>

            </div><!-- /.tab-content -->

        </div>
    </form>
@stop

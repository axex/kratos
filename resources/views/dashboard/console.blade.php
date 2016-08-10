@extends('layouts.back')

@section('content-header')
    <h1>
        控制面板
        <small>概述</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">控制面板</li>
    </ol>
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $subscribes }}<sup style="font-size: 20px">个</sup></h3>
                    <p>本周新增订阅</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('dashboard.subscribe.index') }}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $publishingArticles }}<sup style="font-size: 20px">篇</sup></h3>

                    <p>本周新增内容(文章)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="{{ route('dashboard.article.index') }}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $contributeArticles }}<sup style="font-size: 20px">篇</sup></h3>
                    <p>本周新增投稿</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatboxes"></i>
                </div>
                <a href="{{ route('dashboard.submission.index') }}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65<sup style="font-size: 20px">人次</sup></h3>
                    <p>本周活跃用户访问量</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
@stop


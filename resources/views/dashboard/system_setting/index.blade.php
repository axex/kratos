@extends('layouts.back')

@section('content-header')
  @parent
  <h1>
    系统管理
    <small>系统配置</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.console') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
    <li class="active">系统管理 - 系统配置</li>
  </ol>
@stop

@section('content')

  @include('widgets.back-content-alert')

  <h2 class="page-header">系统配置</h2>
  <form method="post" action="{{ route('dashboard.system.setting') }}" accept-charset="utf-8">
    {{ csrf_field() }}
    <div class="nav-tabs-custom">

      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">网站参数</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">系统参数</a></li>
      </ul>

      <div class="tab-content">
        <p class="text-red">请在超级管理员协助下修改系统配置选项，错误或不合理的修改可能会造成系统运行错误。本表单不对数据做任何校验处理，请务必输入正确与合法的数据。</p>
        <div class="tab-pane active" id="tab_1">
          <div class="form-group">
            <label>网站标题
              <small class="text-green">[website_title]</small>
            </label>
            <input type="text" class="form-control" name="website_title" autocomplete="off"
                   value="{{ $system->website_title or '网站标题'}}" placeholder="网站标题">
          </div>
          <div class="form-group">
            <label>网站关键词
              <small class="text-green">[website_keywords]</small>
            </label>
            <input type="text" class="form-control" name="website_keywords" autocomplete="off"
                   value="{{ $system->website_keywords or '网站关键词'}}" placeholder="网站关键词，多个词请以英文逗号分隔">
          </div>
          <div class="form-group">
            <label>网站描述
              <small class="text-green">[website_dsec]</small>
            </label>
            <input type="text" class="form-control" name="website_dsec" autocomplete="off"
                   value="{{ $system->website_dsec or '网站描述'}}" placeholder="网站描述">
          </div>
          <div class="form-group">
            <label>网站备案号
              <small class="text-green">[website_icp]</small>
            </label>
            <input type="text" class="form-control" name="website_icp" autocomplete="off"
                   value="{{ $system->website_icp or '网站备案号'}}" placeholder="网站备案号">
          </div>
          <div class="form-group">
            <label>后台分页大小
              <small class="text-green">[page_size]</small>
            </label>
            <div class="input-group">
              <select data-placeholder="后台分页大小" class="chosen-select" style="min-width:200px;"
                      name="page_size">
                @if (isset($system->page_size))
                  <option value="10" {{ ($system->page_size == "10") ? 'selected': '' }}>10</option>
                  <option value="15" {{ ($system->page_size == "15") ? 'selected': '' }}>15</option>
                  <option value="20" {{ ($system->page_size == "50") ? 'selected': '' }}>20</option>
                  <option value="25" {{ ($system->page_size == "25") ? 'selected': '' }}>25</option>
                @else
                  <option value="10" selected>10</option>
                @endif
              </select>
            </div>
          </div>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <div class="form-group">
            <label>系统版本号
              <small class="text-green">[system_version]</small>
            </label>
            <input type="text" class="form-control" name="system_version" autocomplete="off"
                   value="{{ $system->system_version or '系统版本号'}}" placeholder="系统版本号">
          </div>
          <div class="form-group">
            <label>系统开发者
              <small class="text-green">[system_author]</small>
            </label>
            <input type="text" class="form-control" name="system_author" autocomplete="off"
                   value="{{ $system->system_author or '系统开发者'}}" placeholder="系统开发者">
          </div>
          <div class="form-group">
            <label>系统开发者网站
              <small class="text-green">[system_author_website]</small>
            </label>
            <input type="text" class="form-control" name="system_author_website" autocomplete="off"
                   value="{{ $system->system_author_website or '系统开发者网站'}}" placeholder="系统开发者网站">
          </div>
        </div><!-- /.tab-pane -->

        <button type="submit" class="btn btn-primary">更新系统配置</button>

      </div><!-- /.tab-content -->

    </div>
  </form>
  <div id="layerPreviewPic" class="fn-hide">

  </div>

@stop

@section('extraPlugin')
  <!--引入Chosen组件-->
  @include('widgets.endChosen')
@stop


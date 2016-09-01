@extends('frontend.subscribe.common')

@section('contentTitle')更新您的偏好@stop

@section('templateBody')
  <form action="/subscribe/profile" method="POST" id="subprefs-form">
    <p class="error">{{ session('repeatEmail') }}</p>
    <p class="error">{{ $errors->first() }}</p>
    {!! csrf_field() !!}
    {{ method_field('put') }}
    <input type="hidden" name="confirmCode" value="{{ $subscribeUser->confirm_code }}">
    <label for="MERGE0">Email地址 <span class="req asterisk">*</span></label>

    <div class="field-group">
      <input type="text" autocapitalize="off" autocorrect="off" name="email" id="MERGE0" size="25"
             value="{{ $subscribeUser->email }}">
    </div>
    <label for="MERGE1">您的姓名</label>

    <div class="field-group">
      <input type="text" name="name" id="MERGE1" size="25" value="{{ $subscribeUser->name or '' }}">
    </div>
    <br>
    <input class="button" type="submit" value="更新配置文件">
    <a class="button" href="{{ '/unsubscribe/' . $subscribeUser->confirm_code }}">取消订阅</a>
  </form>
@overwrite
@extends('frontend.subscribe.common')

@section('content')
    <h2>@section('contentTitle') 订阅已被确认 @stop</h2>
    <div>
        <p>@section('contentDetails') 您对我们列表的订阅已得到确认。 @stop</p>
        <p>@section('contentDetails') 多谢订阅！ @stop</p>
    </div>
    <br>
@section('confirmButton') @parent
<a class="button" href="{{ '/subscribe/profile/' . $subscribeUser->confirm_code }}">管理您的偏好</a> @append
@stop



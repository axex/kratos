@extends('frontend.subscribe.common')

@section('contentTitle')配置文件已被更新@stop

@section('contentDetails')您的配置文件信息已得到更新。 下面是您提交给我们的信息的一个副本，供您留存...@stop

@section('contentDetails') @parent
<ul class="profile-list">
    <li><strong>Email地址:</strong> {{ $subscribeUser->email }}</li>
    <li><strong>您的姓名:</strong> {{ $subscribeUser->name }}</li>
</ul>
@append


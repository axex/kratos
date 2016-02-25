@extends('frontend.subscribe.error')

@section('errorText')
    {{ $subscribeUser->email }}已经被列入订阅名单 kratos收件人.
    <a href="{{ '/subscribe/resend/' . $subscribeUser->confirm_code }}">点击这里更新您的个人资料.</a>
@stop
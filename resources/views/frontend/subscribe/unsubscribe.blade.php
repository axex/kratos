@extends('frontend.subscribe.common')

@section('contentTitle')取消订阅@stop

@section('contentDetails')Kratos 收件人，您要取消的邮件地址是：@stop

@section('confirmButton')
    <form id="mc-unsubscribe-form" action="/unsubscribe/{{ $subscribeUser->confirm_code }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('delete') }}
        <label for="email">{{ $subscribeUser->email }}</label>
        <input class="button" type="submit" value="取消订阅">
    </form>
@stop

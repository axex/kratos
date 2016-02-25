@extends('frontend.subscribe.head')

@section('body')
<div class="wrapper rounded6" id="templateContainer">
    <h1>Kratos收件人</h1>
    @section('templateBody')
    <div id="templateBody" class="bodyContent rounded6">
        <h2>@section('contentTitle')@show</h2>
        <div>
            <p>@section('contentDetails')@show</p>
        </div>
        @section('confirmButton') <a class="button" href="/">&laquo; 返回我们的网站</a> @show
    </div>
    @show
</div>
@stop
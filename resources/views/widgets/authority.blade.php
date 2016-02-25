@extends('layouts.base')

@section('head_css')
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/login.css') }}">
@stop

@section('body_attr') class="page-login" @stop

@section('nav')
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-center">
                <a href="/">Kratos</a>
            </div>
        </div>
    </nav>
@stop


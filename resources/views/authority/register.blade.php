@extends('widgets.authority')

@section('title') 注册 @stop

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <form class="login-form" method="post" action="{{ route('register') }}">

                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}"
                               placeholder="用户名">
                    </div>

                    <div class="form-group">
                        <label for="email">邮箱</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}"
                               placeholder="邮箱">
                    </div>

                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">确认密码</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control">
                    </div>
                    <p class="helper-block" style="clear: both;"><a href="{{ route('login') }}">已经注册? 登录</a></p>

                    <button type="submit" class="btn btn-success btn-block btn-lg">注册</button>

                    <hr>

                </form>
            </div>
        </div>
    </div>
@stop
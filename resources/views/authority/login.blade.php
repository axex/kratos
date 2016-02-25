@extends('widgets.authority')

@section('title') 登录 @stop

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <form class="login-form" method="post" action="{{ route('login') }}">
                    {!! csrf_field() !!}

                    <ul>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif
                        @if(session('status'))
                            <li class="alert-success">{{ session('status') }}</li>
                        @endif
                    </ul>
                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" id="username" name="username" class="form-control"
                               value="{{ old('username') }}"
                               placeholder="用户名">
                    </div>

                    <div class="form-group">
                        <label for="password">密码 <a href="{{ route('reset.password') }}">(忘记密码?)</a></label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <p class="helper-block"><label><input type="checkbox" name="remember" value="1" checked>记住我!</label>
                    </p>

                    {{--<p class="helper-block"><a href="{{ route('register') }}">没有帐号? 立即注册!</a></p>--}}

                    <button type="submit" class="btn btn-success btn-block btn-lg">登录</button>

                    <hr>

                    {{--<div class="login-open">--}}
                    {{--<a class="login-open-btn login-open-github" href="{{ route('login.github') }}">--}}
                    {{--<i class="fa fa-github"></i>--}}
                    {{--<span>使用 GitHub 帐号登录</span>--}}
                    {{--</a>--}}
                    {{--<a class="login-open-btn login-open-weibo" href="{{ route('login.douban') }}">--}}
                    {{--<i class="fa fa-send"></i>--}}
                    {{--<span>使用豆瓣帐号登录</span>--}}
                    {{--</a>--}}
                    {{--</div>--}}

                </form>
            </div>
        </div>
    </div>
@stop
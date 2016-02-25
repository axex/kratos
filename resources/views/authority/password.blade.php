@extends('widgets.authority')

@section('title', '找回密码')

@section('body')
<body class="page-login">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="login-form" method="post" action="{{ route('reset.password') }}">
                {!! csrf_field() !!}
                <ul>
                @if($errors->any())
                        @foreach($errors->all() as $error)
                            <li class="alert-danger">{{ $error }}</li>
                        @endforeach
                @endif

                @if(session('status'))
                    <li class="alert-success">{{ session('status') }}</li>
                @endif

                @if(session('fail'))
                    <li class="alert-danger">{{ session('fail') }}</li>
                @endif
                </ul>

                <div class="form-group">
                    <label for="email">邮箱</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                    <button type="submit" class="btn btn-primary btn-block">获取验证码</button>
                <hr>
                <p class="helper-block"><a href="{{ route('login') }}">返回登录</a></p>
            </form>
        </div>
    </div>
</div>
</body>
@stop
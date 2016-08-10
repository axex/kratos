@extends('widgets.authority')

@section('title', '重置密码')

@section('body')
    <body class="page-login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <form class="login-form" method="post" action="{{ route('reset.confirm') }}">
                    <ul>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif

                        @if(session('status'))
                            <li class="alert-success">{{ session('status') }}</li>
                        @endif

                        @if(session('fail'))
                            <li class="alert-danger">{{ session('fail') }}</li>
                        @endif
                    </ul>
                    {!! csrf_field() !!}
                    <input type="hidden" name="reset_code" value="{{ $resetCode }}">
                    <div class="form-group">
                        <label for="email">邮箱</label>
                        <input type="email" id="email" name="email" disabled="disabled" class="form-control" value="{{ $email }}">
                    </div>

                    <div class="form-group">
                        <label for="password">新密码</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">确认密码</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">重置密码</button>
                    <hr>
                </form>
            </div>
        </div>
    </div>
    </body>
@stop
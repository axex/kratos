<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>推荐文章</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/submission.css') }}">
</head>
<body>
<div class="content">
    <h1>推荐文章给《Kratos》</h1>
        <form action="{{ route('add') }}" method="post" class="pure-form pure-form-aligned ng-pristine ng-invalid ng-invalid-required">
        @if ($errors->any())
            <div class="pure-control-group">
                @foreach($errors->all() as $error)
                    <span class="err-msg">{{ $error }}</span><br>
                @endforeach
            </div>
        @endif
        {{ csrf_field() }}
        <div class="pure-control-group">
            <label for="title">文章标题</label>
            <input id="title" type="text" name="title" value="{{ Input::get('title') ? Input::get('title') : old('title') }}" required maxlength="100"
                   placeholder="100字以内" class="ng-pristine ng-invalid ng-invalid-required">
        </div>
        <div class="pure-control-group">
            <label for="url">文章URL</label>
            <input id="url" type="text" name="url" value="{{ Input::get('url') ? Input::get('url') : old('url') }}" required maxlength="256"
                   placeholder="256字以内">
            @if(Session::has('repeatUrl'))
                <div class="err-msg">{{ session('repeatUrl') }}</div>
            @endif
        </div>
        <div class="pure-control-group">
            <label for="description">推荐理由</label>
            <textarea id="description" type="text" name="desc" maxlength="512"
                      placeholder="请填写为什么推荐这篇文章或者该文章的简介，512字内">{{ old('desc') }}</textarea>
        </div>
        <div class="pure-control-group">
            <label for="title">关键词</label>
            <input id="title" type="text" maxlength="64" value="{{ old('tags') }}" name="tags"
                   placeholder="比如Javascript, 响应式。多个用逗号隔开">
        </div>
        <div class="pure-control-group">
            <label for="title">您的名字</label>
            <input id="title" type="text" value="{{ old('presenter') }}" name="presenter" maxlength="256">
        </div>
        <div class="pure-controls">
            <button type="submit" class="pure-button pure-button-primary">提交</button>
        </div>
    </form>
</div>
</body>
</html>

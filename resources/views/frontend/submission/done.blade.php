<!doctype html>
<html ng-app>
<head>
    <meta charset="utf-8">
    <title>推荐文章</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/submission.css') }}">
</head>
<body class="done">
<div class="content content-done">
    <h1>感谢您对《奇舞周刊》的贡献！</h1>
    <p>您可以<a href="{{ route('add') }}">再推荐一篇</a>或者<a href="/">阅读已经发布的周刊</a>。</p>
    <p>您也可以将「<a href="javascript:window.open('http://kratos.com/add?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href));" title="把我拖到收藏栏吧！" style="cursor:move">推荐到奇舞周刊</a>」拖到收藏栏，以后看到喜欢的文章点一下就可以推荐咯。</p>
</div>
</body>
</html>
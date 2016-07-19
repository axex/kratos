<!doctype html>
<html>
<head>
    <title>Kratos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/index.css') }}">
</head>
<body>
<div id="doc">
    <header id="hd">
        <div class="container">
            <a class="logo" href="/">
                <h1>Kratos</h1>
            </a>
            <div class="overview">
                <h2 class="title">领略前端技术 阅读奇舞周刊</h2>

                <p class="desc">我们收集每周前端精华文章，集结成册，每周五发送至您的邮箱。</p>

                <form action="/subscribe" method="post" target="_blank" class="subscribe">
                    {{ csrf_field() }}
                    <input class="email" placeholder="请输入email" name="email">
                    <button class="submit" type="submit">订阅</button>
                </form>
            </div>
        </div>
    </header>
    <section class="" id="bd">
        <div class="issues container">
            <h3 class="title">最新发布的周刊</h3>
            <ol class="issue-list">
                @foreach($issues as $issue)
                    <li><span class='date'>{{ $issue->created_at->toDateString() }}</span><a href='{{ route('issue', $issue->issue) }}'>Kratos第{{ $issue->issue }}期</a></li>
                @endforeach
            </ol>
        </div>
        <!-- 多说评论框 start -->
        <div class="ds-thread container" data-thread-key="index" data-title="Kratos" data-url="http://kratos.com"></div>
        <!-- 多说评论框 end -->
    </section>
    <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
    <script type="text/javascript">
        var duoshuoQuery = {short_name:"kratos"};
        (function() {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';ds.async = true;
            ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0]
            || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>
    <!-- 多说公共JS代码 end -->
    <footer id="ft">
        本网页内容由互联网资料整理而成
    </footer>
</div>

<div class="add-link">
    <a href="{{ route('add') }}" title="推荐文章到奇舞周刊">推荐文章</a>
</div>

</body>
</html>

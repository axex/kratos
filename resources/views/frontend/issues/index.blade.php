<!doctype html>
<html>
<head>
    <title>Kratos第{{ $issue }}期</title>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/issue.css') }}">
</head>
<body>
<div id="doc">
    <header id="hd">
        <div class="container">
            <h1 class="logo"><a href="/">Kratos</a></h1>
            <div class="issue">Issue<em>{{ $issue }}</em></div>
            <a class="add-link" href="{{ route('add') }}" title="推荐文章到Kratos">提交链接</a>
        </div>
    </header>
    <main class="container" id="main">
        <section id="content">
            <ul>
                @foreach($articles as $article)
                <li>
                    <h2>{{ $article[0]->category->name }}</h2>
                </li>
                @foreach($article as $art)
                    <li class="article">
                        <h3 class="title">
                            <a href="{{ $art->url }}" target="_blank">{{ $art->title }}</a>
                        </h3>
                        <p class="desc">{!! $art->desc !!}</p>
                        <div class="meta">
                            @foreach($art->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                            @endforeach
                            @if (! empty($art->presenter))
                                <span class="provider">{{ $art->presenter }}推荐</span>
                            @endif
                        </div>
                    </li>
                @endforeach
                @endforeach
            </ul>
        </section>
        <aside id="aside">
            <h2>搜索《Kratos》</h2>
            <div class="subscribe">
                <form action="/search" method="get">
                    <input type="text" value="" name="q" class="required email" placeholder="请输入查询词">
                    <div class="action">
                        <input type="submit" value="搜索一下" class="button">
                    </div>
                </form>
            </div>
            <h2>订阅《Kratos》</h2>
            <div class="subscribe">
                <!-- Begin MailChimp Signup Form -->
                <form action="/subscribe" method="post" class="validate" target="_blank">
                    {{ csrf_field() }}
                    <input type="email" value="" name="email" class="required email" placeholder="Email地址">
                    <div class="action">
                        <input type="submit" value="立即订阅" class="button">
                    </div>
                </form>
                <!--End mc_embed_signup-->
            </div>
            <h2>最新发布</h2>
            <ul class="issues" id="latest_issues">
                @foreach($latestIssues as $latestIssue)
                    <li><span class="date">{{ $latestIssue->published_at->toDateString() }}</span>
                        <a href="/issue{{ $latestIssue->issue }}">Kratos第{{ $latestIssue->issue }}期</a></li>
                @endforeach
            </ul>
        </aside>
    </main>
    <div class="container comments">
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="{{ $issue }}" data-title="Kratos 第{{ $issue }}期"
             data-url="{{ URL::current() }}"></div>
        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
        <script type="text/javascript">
            var duoshuoQuery = {short_name: "kratos"};
            (function () {
                var ds = document.createElement('script');
                ds.type = 'text/javascript';
                ds.async = true;
                ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                ds.charset = 'UTF-8';
                (document.getElementsByTagName('head')[0]
                || document.getElementsByTagName('body')[0]).appendChild(ds);
            })();
        </script>
        <!-- 多说公共JS代码 end -->
    </div>
    <footer id="ft" class="container">
        本网页内容由互联网资料整理而成
    </footer>
</div>
</body>
</html>


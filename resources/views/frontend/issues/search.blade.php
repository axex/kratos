<!doctype html>
<html>
<head>
    <title>搜索《Kratos》</title>
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
            <a class="add-link" href="{{ route('add') }}" title="推荐文章到Kratos">提交链接</a>
        </div>
    </header>
    <main class="container" id="main">
        <section id="content">
            <form id="st-search-form">
                <input type="text" name="q" id="st-search-input"/>
                <input type="submit" value="搜索" id="st-search-btn">
            </form>
            <div id="st-results-container">
                @if($articles->isEmpty())
                    <div><h3><em>未查询到相关内容！</em></h3></div>
                @else
                @foreach($articles as $article)
                    <div class="st-result">
                        <h3>
                            <a href="/issue{{ $article->issue->issue }}">{{ $article->title }}</a>
                        </h3>
                        <div><span>Kratos第{{ $article->issue->issue }}期</span></div>
                    </div>
                @endforeach
                @endif
            </div>
            {!! $articles->appends(['q' => Request::get('q')])->render() !!}
        </section>
        <aside id="aside">
            <h2>最新发布</h2>
            <ul class="issues" id="latest_issues">
                @foreach($latestIssues as $latestIssue)
                    <li><span class="date">{{ $latestIssue->published_at->toDateString() }}</span><a
                                href="/issue{{ $latestIssue->issue }}">Kratos第{{ $latestIssue->issue }}期</a></li>
                @endforeach
            </ul>
        </aside>
    </main>
    <footer id="ft" class="container">
        Kratos内容由互联网资料整理而成
    </footer>
</div>
</body>
</html>


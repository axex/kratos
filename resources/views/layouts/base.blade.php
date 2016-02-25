@section('funny_header')
{{-- 头部申明区域 --}}
@show

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - KRATOS</title>
    <meta name="description" content="{{ $description or 'Kratos AdminLTE' }}" />
    <meta name="keywords" content="{{ $description or 'Kratos AdminLTE' }}" />
    <meta name="renderer" content="webkit">{{-- 360浏览器使用webkit内核渲染页面 --}}
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />{{-- IE(内核)浏览器优先使用高版本内核 --}}

    @section('meta')
        {{-- 添加一些额外的META申明 --}}
    @show

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">{{-- favicon --}}

    @section('head_css')
        {{-- head区域css样式表 --}}
    @show

    @section('head_js')
        {{-- head区域javscript脚本 --}}
    @show

    @section('before_style')
        {{-- 在内联样式之前填充一些东西 --}}
    @show

    @section('head_style')
        {{-- head区域内联css样式表 --}}
    @show

    @section('after_style')
        {{-- 在内联样式之后填充一些东西 --}}
    @show
</head>
<body @section('body_attr')class=""@show{{-- 追加类属性 --}}>
    @section('nav')
        {{-- 导航 --}}
    @show

    @section('beforeBody')
        {{--在正文之后填充一些东西 --}}
    @show

    @section('body')
    @show{{-- 正文部分 --}}

    @section('afterBody')
    @show{{-- 在正文之后填充一些东西，比如统计代码之类 --}}
</body>
</html>

@section('funny_footer')
    {{-- 尾部申明区域 --}}
@show
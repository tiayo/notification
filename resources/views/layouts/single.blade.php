<!doctype html>
<html lang="en" class="@yield('page_type')">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('site.title')}}-@yield('title')</title>
    @section('link')
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/vendor/animate.css/animate.css">
        <link rel="stylesheet" href="/stylesheets/css/style.css">
        {{--这里放css样式--}}
    @show
</head>

<body>

<div class="wrap">
    @section('content_body')
        {{--这里是主要内容--}}
    @show
</div>

@section('script')
    <script src="/js/app.js"></script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    {{--这里放js文件引用--}}
@show
</body>
</html>
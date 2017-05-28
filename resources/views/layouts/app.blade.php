<!doctype html>
<html lang="en" class="fixed">
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
        <link href="/css/app.css" rel="stylesheet">
        {{--这里放css样式--}}
    @show
</head>

<body>

<div class="wrap">

    {{--头部--}}
    @if (!isset($header) || $header != false)
        @include('admin.header')
    @endif

    <div class="page-body">

        {{--这里是侧边栏--}}
        @if (!isset($header) || $header != false)
            @include('admin.sidebar')
        @endif

        <div class="content">

            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        @section('breadcrumbs')
                            {{--这里是面包屑--}}
                        @show
                    </ul>
                </div>
            </div>

            @section('content_body')
                {{--这里是主要内容--}}
            @show

        </div>

        {{--这里是右边快捷栏--}}
        @if (!isset($header) || $header != false)
            @include('admin.right')
        @endif

    </div>
</div>

@section('script')
    {{--主文件--}}
    <script src="/js/app.js"></script>
    {{--自动打开菜单层级--}}
    <script type="text/javascript">
        $(document).ready(function () {
            var num = $('.breadcrumbs li').length;
            for (i=0; i<=num; i++) {
                var nav_value = $('.breadcrumbs li:eq('+i+')').attr('navValue');
                $('nav li').removeClass('active-item');
                $('#'+nav_value).removeClass('close-item');
                $('#'+nav_value).addClass('open-item active-item');
            }
        })
    </script>
    {{--这里放js文件引用--}}
@show

</body>
</html>
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
    @include('admin.header')

    <div class="page-body">

        {{--这里是侧边栏--}}
        @include('admin.sidebar')

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
        @include('admin.right')

    </div>
</div>

@section('script')
    <script src="/js/app.js"></script>
    {{--这里放js文件引用--}}
@show

</body>
</html>
<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>@yield('title')-{{config('site.title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="随享,随享校园社区,随享笔记本,随享记事本,祥景CMS">
    <meta name="Description" content="@yield('description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @section('link')
        {{--这里放css样式--}}
    @show

<body>
<!--头部-->
@section('header')
    @include('front.header')
@show
<!--头部-->

<!--主体部分-->
<div class="zhuti">
    <div class="i_comcont">
        <div class="main">
            <div class="clearfix i_comtab">
                <dl>
                    <dd pan="Com-RecommendTag" class="on"><a href="/">首页</a></dd>
                    {!! app('\App\Service\CategoryService')->categoryHtml('<dd pan="Com-RecommendTag" class="on"><a href="/category/<<category_id>>.html"><<title>><i></i></a></dd>', 'article') !!}
                </dl>
            </div>
            @section('content_body')
                {{--这里是主要内容--}}
            @show
        </div>
        @include('front.right')
    </div>
</div>
<!--主体部分-->
﻿
<!--底部-->
@section('footer')
    @include('front.footer')
@show

@section('script')
    {{--主文件--}}
    <script src="/js/app.js"></script>
    {{--这里放js文件引用--}}
@show

</body>
</html>
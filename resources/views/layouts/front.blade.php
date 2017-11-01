@inject('category', '\App\Services\CategoryService')
@inject('article', '\App\Repositories\ArticleRepository')
<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>@yield('title')-{{config('site.title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="随享,随享中国社区,随享笔记本,随享记事本,祥景CMS">
    <meta name="Description" content="@yield('description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{ asset('/css/comindex.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/publicpack.css') }}" rel="stylesheet"/>
    @section('link')
        {{--这里放css样式--}}
    @show

<body>
<!--头部-->
@section('header')
    @include('front.header')
@show
<!--头部-->

{{--大图--}}
@php
    $headlines = $article->findOneRand([['attribute', 4]], '*');
@endphp

@if (!empty($headlines))
    <div id="communityHeadImgRegion" class="i_newshead">

        <div id="communityHeadImgTgRegion" class="ddtip">
            <div method="tipbox" class="ddtiper none">
                <div class="ddtipbox">
                    <i method="close" class="tip_close"></i>
                    <div id="" method="tip">
                    </div>
                </div>
            </div>
        </div>
        <ul id="communityHeadImgBackSlidesRegion" class="bgimg">
            <li style="
                    background-image:url({{ $headlines['picture'] }});
                    opacity:1;
                    z-index:2;
                    background-repeat:no-repeat;
                    background-size: 100% 100%;
                    "></li>
        </ul>
        <div class="i_newsimgs">
            <div class="dl">
                <dl id="communityHeadImgSlidesRegion" class="clearfix">
                    <dd style="opacity:1;z-index:2;" class="__r_c_">
                        <div class="clearfix i_combox __r_c_">
                            <div class="i_textbox">
                                <div class="pic_60">
                                    <a href="/{{ config('site.article_path').$headlines['links'] }}">
                                        <img src="{{ $headlines->profile->avatar }}" width="60" height="60" class="userimg">
                                    </a>
                                    <h3>
                                        <a href="/{{ config('site.article_path').$headlines['links'] }}" target="_blank">
                                            {{ $headlines['title'] }}
                                        </a>
                                    </h3>
                                    <p class="mt12 px16 lh16">
                                        <span class="i_quto"></span>
                                        {{ $headlines['abstract'] }}
                                    </p>
                                    <p class="mt12 px14">
                                        <a href="/{{ config('site.article_path').$headlines['links'] }}">
                                            {{ $headlines->profile->real_name }}
                                        </a>
                                        <i class="ml6 mr6">阅读</i>
                                        <strong class="db_point">
                                            {{ $headlines['click'] }}
                                        </strong>
                                    </p>
                                </div>

                                <div class="pic30box">
                                    @foreach ($headlines->comment as $comment)
                                        <div class="pic_30">
                                            <a href="#"><img src="{{ $comment->profile->avatar }}" width="30" height="30"></a>
                                            <p><a href="#">{{ $comment->profile->real_name }}</a> 说:</p>
                                            <p class="px14">{{ $comment['content'] }}</p>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endif
{{--大图--}}

<!--主体部分-->
<div class="zhuti">
    <div class="i_comcont">
        <div class="main">
            <div class="clearfix i_comtab">
                <dl>
                    <dd pan="Com-RecommendTag" class="on"><a href="/">首页</a></dd>
                    @foreach ($category->getWhereParent('article') as $category)
                        <dd pan="Com-RecommendTag">
                            <a href="/category/{{ $category['category_id'] }}.html">
                                {{ $category['name'] }}
                                <i></i>
                            </a>
                        </dd>
                    @endforeach
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
@extends('layouts.article')
@section('title', $article['title'])
@section('description', $article['abstract'])

@section('link')
    <link href="/index.css" rel="stylesheet" />
    <link href="/article.css" rel="stylesheet"/>
@endsection

@section('header')
    @parent
@endsection

@section('content_body')
<div class="newshead " style="background-color:; background-image:url();">
    <div class="newsheader ">
        <div class="" id="M14_B_CMSNews_Common_HeadTG"></div>
        <div class="newsheadtit">
            <h2>{{$article['title']}}</h2>
        </div>
        <p class="mt15 ml25 newstime ">分类：{{$article['name']}}&emsp;发布时间：{{$article['created_at']}}&emsp;阅读：<span id="click"></span>&emsp;
            <span class="ml15"><a href="#">作者：{{$article['real_name']}}</a></span>
            <span><a href="#pinglun" class="icon_nbbs" title="评论"></a></span>
        </p>
    </div>
</div>
<div class="newsinnerhrtit" id="newsPageTitle" style="display:none;"></div>
<div class="newscont clearfix"><div class="clearfix newsconter2">
        <div class="newsl">
            <div class="neirongkaishi" id="neirongkaishi">
                @if (!empty($article['picture']))
                    <p style="max-width: 100%; text-align: center;">
                        <img src="{{$article['picture']}}" style="max-width: 100%;">
                    </p>
                    <hr style="margin: 1em 0 1.5em 0;borber:1px solid #ccc;">
                @endif
                {!! $article['body'] !!}
            </div>  　　
            <p class="newsediter">&nbsp;&nbsp;&nbsp;编辑：{{$article['real_name']}}</p>
            <div class="newswarm">[随享社区版权所有 未经许可不得转载 ]</div>
            <img src="/images/code.jpg" class="article_img mt15"/>
            <div id="comment_block"></div>
        </div>

        <div class="newsr">
            <div id="M14_B_CMSNews_Common_SquareTG1"></div>
            <div id="newsECommerceInfo"></div>
            <div class="newslinks">
                <h4>作者信息</h4>
                <dl id="relatedInfos-writer">
                    <dd style=""><img src="{{$article['avatar']}}" width="96"/>
                        <h3>{{$article['real_name']}}</h3>
                        <p>城市：{{$article['city']}}</p>
                        <p>邮箱:<small>{{$article['email']}}</small></p>
                    </dd>
                </dl>
            </div>
            @if (!empty($me))
            <div class="newslinks">
                <h4>我的信息</h4>
                <dl id="relatedInfos-me">
                    <dd style=""><img src="{{$me['avatar']}}" width="96"/>
                        <h3>{{$me['real_name']}}</h3>
                        <p>城市：{{$me['city']}}</p>
                        <p>邮箱：<small>{{$me['email']}}</small></p>
                        <p>进入：<a href="/admin" target="_blank">控制台</a></p>
                    </dd>
                </dl>
            </div>
            @endif
            <div class="newslinknews" id="tit">
                <h4>相关文章</h4>
                <ul>
                    @foreach ($article_rand as $item)
                    <li>
                        <strong>·</strong>
                        <p>
                            <a href="/{{config('site.article_path').$item['links']}}" target="_blank">{{$item['title']}}</a>
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <script type="text/javascript">  //相关文章悬浮
            var tit = document.getElementById('tit');
            var star = tit.offsetTop;
            var pos = tit.offsetHeight;
            window.onscroll = function() {
                var kaishi = star - 70;
                var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop; //完美赋值兼容ie浏览器
                if(scrollTop >= kaishi) {
                    tit.style.position = "fixed";
                    tit.style.marginTop = "70px";
                    tit.style.top = 0;
                } else {
                    tit.style.position = "";
                    tit.style.marginTop = "";
                }
            }
        </script>
    </div><div id="M14_B_CMSNews_CommentAboveTG"></div>
</div>
<div id="shuchu"></div>
<div class="fanhui_index">
    <p><a href="/">返回首页</a></p>
</div>
@endsection

@section('footer')
    @parent
@endsection

@section('script')
    @parent
    @include('front.login_status')
    @include('front.user_is_identical')
    <script src="/ueditor/ueditor.parse.min.js"></script>
    <script type="text/javascript">
        window.onload=function(){
            uParse('#neirongkaishi', {
                rootPath: '/ueditor'
            });
        };
    </script>
    @include('front.article_js')
@endsection
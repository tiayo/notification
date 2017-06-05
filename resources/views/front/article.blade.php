@extends('layouts.article')
@section('title', $category['name'] ?? '祥景CMS')
@section('description', '随享校园社区是基于祥景CMS架构的一套分享php学习之路的网站,大量常用的代码和常遇到的问题不断更新中.')

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
                {!! $article['body'] !!}
            </div>  　　
            <p class="newsediter">&nbsp;&nbsp;&nbsp;编辑：{{$article['real_name']}}</p>
            <div class="newswarm">[随享社区版权所有 未经许可不得转载 ]</div>
            <img src="/images/code.jpg" class="article_img mt15"/>
            <script>
                function  kong() {
                    $("#pinglunform1").css("display","none"),
                        $("#pinglunform2").css("display","block");
                    $(".pinglunsubmit input").css("background","#666666");
                }
            </script>
            <div class="pinglun" id="pinglun">
                <form action="/home/article/pinglun_add" id="pinglunform1"  method="post" target="myiframe" style="display:block;">
                    <div class="pingluntext"><textarea id="textarea" type="text" name="q"></textarea></div>
                    <input name="wenzhang_aid" value="238" style="display:none"/>
                    <input type="hidden" name="__hash__" value="8249e443bb728a80edc42f89e4ef399e_b3da13af824f02322c388aa1601f7b3b" />
                    <div class="pinglunsubmit"><input type="submit" onclick="kong()"></div>
                </form>
                <form action="/home/article/pinglun_add" id="pinglunform2"  method="post" target="myiframe" style="display:none;">
                    <div class="pingluntext"><textarea id="textarea" type="text" name="q"></textarea></div>
                    <input name="wenzhang_aid" value="41" style="display:none"/>
                    <div class="pinglunsubmit"><input type="button" value="您已评论"></div>
                </form>
                <iframe name="myiframe" style="position:relative;top:-35px;height:30px;border:none;width:55%;" scrolling="no";></iframe>
            </div>
            <div id="shuchu"></div>
        </div>

        <div class="newsr">
            <div id="M14_B_CMSNews_Common_SquareTG1"></div>
            <div id="newsECommerceInfo"></div>
            <div class="newslinks">
                <h4>作者信息</h4>
                <dl id="relatedInfos">
                    <dd style=""><img src="{{$article['avatar']}}" width="96"/>
                        <h3>{{$article['real_name']}}</h3>
                        <p>城市：{{$article['city']}}</p>
                        <p>邮箱:{{$article['email']}}</p>
                        <p>联系他：<a href="/Home/Article/liuyan?id=12" target="_blank">给他留言</a></p>
                    </dd>
                </dl>
            </div>
            @if (!empty($me))
            <div class="newslinks">
                <h4>我的信息</h4>
                <dl id="relatedInfos">
                    <dd style=""><img src="{{$me['avatar']}}" width="96"/>
                        <h3>{{$me['real_name']}}</h3>
                        <p>城市：{{$me['city']}}</p>
                        <p>邮箱：{{$me['email']}}</p>
                        <p>进入：<a href="/admin" target="_blank">控制台</a></p>
                    </dd>
                </dl>
            </div>
            @endif
            <div class="newslinknews" id="tit">
                <h4>相关文章</h4>
                <ul>
                    @foreach ($article_rand as $article)
                    <li>
                        <strong>·</strong>
                        <p>
                            <a href="{{config('site.article_path').$article['links']}}" target="_blank">{{$article['title']}}</a>
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
    <script src="/ueditor/ueditor.parse.min.js"></script>
    <script type="text/javascript">
        window.onload=function(){
            uParse('#neirongkaishi', {
                rootPath: '/ueditor'
            });
        };

        //文章点击数
        $(document).ready(function () {
            axios.post('/ajax/get_click/{{$article['article_id']}}', {
                _token: '{{csrf_token()}}'
            })
                .then(function (response) {
                    $('#click').html(response.data);
                })
                .catch(function (response) {
                    $('#click').html(0);
                });
        })
    </script>

@endsection
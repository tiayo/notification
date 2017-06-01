<div id="topbar" class="fixed">
    <div class="headbar" id="headbar">
        <dl class="headbarnav">
            <h1><a title="" href="/"><img src="/images/logo.png" /></a></h1>
            {!! app('\App\Service\CategoryService')->categoryHtml('<dd class=""><a href="/category/<<category_id>>.html"><<title>><i></i></a></dd>', 'article') !!}
            </dl>
        <div class="headtool" id="loginbox">
            <div class="sousuo">
                <form method="get" action="/Home/index/serch">
                    <input class="text" type="text" placeholder="例如：mysql,php" name="key"/>
                    <input class="submit" type="submit" value="搜索"/>
                    <input type="hidden" name="__hash__" value="e40be545251181a5363811a2e023d9a9_68f211e4a17384c4d292c80d477df3a4" /></form>
            </div>
            <i class="line"></i>
            <div id='loginStatus' style="float:left;">
                @if (!empty(Auth::id()))
                    <div class="headunlogin"><a href="/admin">控制台<i></i></a><em></em><a href="{{route('logout')}}">退出</a> </div>
                    @else
                    <div class="headunlogin"><a href="/login">登录<i></i></a><em></em><a href="/register" target="_blank">注册</a> </div>
                @endif
            </div>
            <div class="headcart" id="shopbox">
                <strong><a href="/admin/index/right" target="_blank">发布</a></strong>
            </div>
        </div>

    </div>
</div>
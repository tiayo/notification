<div id="topbar" class="fixed">
    <div class="headbar" id="headbar">
        <dl class="headbarnav">
            <h1><a title="" href="/"><img src="/images/logo.png" /></a></h1>
            {!! app('\App\Service\CategoryService')->categoryHtml('<dd class=""><a href="/category/<<category_id>>.html"><<title>><i></i></a></dd>', 'article') !!}
            </dl>
        <div class="headtool" id="loginbox">
            <div class="sousuo">
                <form method="get" id="search_form">
                    <input class="text" type="text" placeholder="例如：mysql,php" id="search_form_key"/>
                    <input class="submit" type="submit" id="search_form_button" value="搜索"/>
                </form>
            </div>
            <i class="line"></i>
            <div id='loginStatus' style="float:left;">
                <div class="headunlogin" style="display: none" id="login_status"><a href="/admin">控制台<i></i></a><em></em><a href="{{route('logout')}}">退出</a> </div>
                <div class="headunlogin" id="no_login_status"><a href="/login">登录<i></i></a><em></em><a href="/register" target="_blank">注册</a> </div>
            </div>
            <div class="headcart" id="shopbox">
                <strong><a href="/admin/index/right" target="_blank">发布</a></strong>
            </div>
        </div>
    </div>
</div>
<div class="sieder">
    <div id="M14_B_CommunityIndex_HotGroupAboveTG"></div><div class="com_mod">
        <h4>置顶信息</h4>
        <dl class="com_hotgroup">
            @foreach ($article_top as $article)
                <dd class='__r_c_' pan='Com-RecommendGroup2'>
                    <h3><a href='{{config('site.article_path').$article['links']}}' target='_blank'>{{$article['title']}}</a></h3>
                    <p>{{$article['updated_at']}}</p>
                </dd>
            @endforeach
        </dl>
        <div class="com_hotgroup">
            <ul class="clearfix">
                {!! app('\App\Service\CategoryService')->categoryHtml('<li><a href="/category/<<category_id>>.html" target="_blank"><<title>><i></i></a></dd>', 'article') !!}
            </ul>
        </div>
    </div><div id="M14_B_CommunityIndex_HotUserAboveTG"></div><div class="com_mod">
        <h4 class="mt25">最新会员</h4>
        <div id="divHotUsersPerson">
            <dl class="com_hotuser" id="divHotPerson">
                @foreach (app('App\Profile')->limit(5)->get() as $user)
                <dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='{{$user['avatar']}}'></a>
                    <h3><a>{{$user['real_name']}}</a></h3>
                    <p class='mt6'>城市：{{$user['city']}}</p>
                    <p class='mt5'>注册时间：{{$user['created_at']}}</p>
                </dd>
                @endforeach
            </dl>
        </div>
    </div>
</div>
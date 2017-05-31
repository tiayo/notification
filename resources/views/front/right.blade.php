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
                <li><a href="/list/1.html" target="_blank">linux日志</a></li><li><a href="/list/5.html" target="_blank">PHP记事本</a></li><li><a href="/list/6.html" target="_blank">Jquery记事本</a></li><li><a href="/list/7.html" target="_blank">Mysql记事本</a></li>
            </ul>
        </div>
    </div><div id="M14_B_CommunityIndex_HotUserAboveTG"></div><div class="com_mod">
        <h4 class="mt25">最新会员</h4>

        <div id="divHotUsersPerson">
            <dl class="com_hotuser" id="divHotPerson">
                <dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='/upload/2016/09/23/1474635828.jpg'></a>
                    <h3><a>迷你猪</a></h3>
                    <p class='mt6'>学校：黎明大学</p>
                    <p class='mt5'>家乡：福建泉州</p>
                </dd><dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='/upload/2016/09/23/1474635827.jpg'></a>
                    <h3><a>大张伟</a></h3>
                    <p class='mt6'>学校：闽南科技大学</p>
                    <p class='mt5'>家乡：福建泉州详细地址</p>
                </dd><dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='/upload/2016/09/23/1474622348.jpg'></a>
                    <h3><a>陈伟霆</a></h3>
                    <p class='mt6'>学校：华侨大学</p>
                    <p class='mt5'>家乡：福建厦门</p>
                </dd><dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='/Uploads/2016-11-23/583552124d74a.jpg'></a>
                    <h3><a>郑祥景</a></h3>
                    <p class='mt6'>学校：泉州师范学院软件学院</p>
                    <p class='mt5'>家乡：福建泉州</p>
                </dd><dd class='__r_c_' pan='Com-HotPerson1'>
                    <a><img width='52' height='52' src='/Uploads/2016-11-23/583526f7f2c6a.jpg'></a>
                    <h3><a>超级管理员</a></h3>
                    <p class='mt6'>学校：泉州师范学院</p>
                    <p class='mt5'>家乡：福建泉州</p>
                </dd>
            </dl>
        </div>
    </div>
</div>
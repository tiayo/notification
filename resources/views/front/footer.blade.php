<div id="bottom">
    <div class="footout">
        <span class="topline"></span>
        <div class="footinner clearfix">
            <div class="fotlogo">
                <dl>
                    <dt><a href="/">随享社区</a></dt>
                    <dd class="clearfix"><a href="javascript:void();">加入我们</a></dd>
                    <dd class="clearfix"><a href="/article/version.html" class="ml30">更新日志</a></dd>
                    <dd class="clearfix"><a href="/article/retrieval.html" class="ml30">检索目录</a></dd>
                    <dd class="clearfix"><a href="/sitemap.xml">网站地图</a></dd>
                </dl>
                <i class="line"></i>
            </div>
            <div class="fotmap">
                <dl style="width:300px;">
                    <dt>推荐</dt>
                    {!! app('\App\Service\CategoryService')->categoryHtml('<dd><a href="/category/<<category_id>>.html"><<title>><i></i></a></dd>', 'article') !!}
                </dl>
                <i class="line"></i>
                <div id="divWeiXinPicContainer" class="my_layer" style="display: none;">
                    <em class="l_arrow">&nbsp;</em><div class="inner p15" style="width:195px;">
                        <i></i><p>扫描二维码，微信实时关注随享</p>
                    </div>
                </div>
            </div>
            <div class="fotweek">
                <dl>
                    <dt class="clearfix"><span class="fr">在线客服</span><strong>随享宝宝</strong></dt>
                    <dd><a href="/liaotian" target="_blank"><img src="/images/zaixiankefu.jpg" width="170"></a></dd>
                    <dd>有任何问题，都可以戳我反馈哦！</dd>
                </dl>
            </div>
            <div class="fothr">
                <dl>
                    <dt><strong>微信公众号</strong> 方便 快速</dt>
                    <dd><a href="javascript:void();" target="_blank"><i></i></a></dd>
                    <dd>扫描二维码 关注公众号</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="db_foot">
        <p><span class="mr12">版权所有：{{config('site.title').config('site.version')}} 版本</span>Copyright 2015-{{date('Y')}} tiayo.com Inc. All rights reserved.<script src="https://s11.cnzz.com/z_stat.php?id=1261611384&web_id=1261611384" language="JavaScript"></script></p>

    </div>
</div>
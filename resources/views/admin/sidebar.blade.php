<div class="left-sidebar">
    <div class="left-sidebar-header">
        <div class="left-sidebar-title color-light">{{config('site.title')}}</div>
        <div class="left-sidebar-toggle c-hamburger c-hamburger--htla hidden-xs" data-toggle-class="left-sidebar-collapsed" data-target="html">
            <span></span>
        </div>
    </div>
    <div id="left-nav" class="nano has-scrollbar">
        <div class="nano-content" tabindex="0" style="right: -15px;">
            <nav>
                <ul class="nav" id="main-nav">
                    <li id="nav_0"><a href="/"><i class="fa fa-home" aria-hidden="true"></i><span>控制台</span></a></li>
                    <li id="nav_4" class="has-child-item close-item">
                        <a><i class="fa fa-cubes" aria-hidden="true"></i><span>我的文章</span></a>
                        <ul class="nav child-nav level-1">
                            <li id="nav_4_1"><a href="/admin/article/page">全部文章</a></li>
                            <li id="nav_4_2" class="has-child-item close-item">
                                <a href="#">添加文章</a>
                                <ul class="nav child-nav level-2">
                                    {!! app('\App\Service\CategoryService')->categoryHtml('<li id="nav_4_<<num>>"><a href="/admin/article/add/<<category_id>>"><<title>></a></li>', 'article') !!}
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li id="nav_1" class="has-child-item close-item">
                        <a><i class="fa fa-cubes" aria-hidden="true"></i><span>我的任务</span></a>
                        <ul class="nav child-nav level-1">
                            <li id="nav_1_1"><a href="/admin/task/page">全部任务</a></li>
                            <li id="nav_1_2"><a href="/admin/task/add">添加任务</a></li>
                        </ul>
                    </li>
                    <li id="nav_2" class="has-child-item close-item">
                        <a><i class="fa fa-pie-chart" aria-hidden="true"></i><span>我的订单</span></a>
                        <ul class="nav child-nav level-1">
                            <li id="nav_2_1" ><a href="/admin/sponsor">赞助我们</a></li>
                            <li id="nav_2_2" ><a href="/admin/order/page">全部订单</a></li>
                        </ul>
                    </li>
                    @if (app('App\Service\IndexService')::admin() === true)
                    <li id="nav_3" class="has-child-item close-item">
                        <a><i class="fa fa-columns" aria-hidden="true"></i><span>管理操作</span></a>
                        <ul class="nav child-nav level-1">
                            <li id="nav_1"><a href="/admin/category/page/1">管理分类</a></li>
                            <li id="nav_2"><a href="/admin/refund/page/1">管理退款</a></li>
                            <li id="nav_3"><a href="/admin/generate/view">生成文章</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="nano-pane" style=""><div class="nano-slider" style="height: 443px; transform: translate(0px, 0px);"></div></div></div>
</div>
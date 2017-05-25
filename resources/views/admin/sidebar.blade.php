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
                    <li class="active-item"><a href="/"><i class="fa fa-home" aria-hidden="true"></i><span>控制台</span></a></li>
                    <li class="has-child-item close-item">
                        <a><i class="fa fa-cubes" aria-hidden="true"></i><span>我的任务</span></a>
                        <ul class="nav child-nav level-1">
                            <li><a href="/admin/task/page">我的任务</a></li>
                            <li><a href="/admin/task/add">添加任务</a></li>
                        </ul>
                    </li>
                    <li class="has-child-item close-item">
                        <a><i class="fa fa-pie-chart" aria-hidden="true"></i><span>我的订单</span></a>
                        <ul class="nav child-nav level-1">
                            <li><a href="/admin/sponsor">赞助我们</a></li>
                            <li><a href="/admin/order/page">我的订单</a></li>
                        </ul>
                    </li>
                    @if (app('App\Service\IndexService')::admin() === true)
                    <li class="has-child-item close-item">
                        <a><i class="fa fa-columns" aria-hidden="true"></i><span>管理操作</span></a>
                        <ul class="nav child-nav level-1">
                            <li><a href="/admin/category/page/1">管理分类</a></li>
                            <li><a href="/admin/refund/page/1">管理退款</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="nano-pane" style=""><div class="nano-slider" style="height: 443px; transform: translate(0px, 0px);"></div></div></div>
</div>
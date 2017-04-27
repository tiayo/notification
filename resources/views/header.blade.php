<!------------公用头部 start------------>
<!--顶部导航条-->
<div id="topnav">
    <div class="main clearfix">
    @if(empty($user_name->username))
		<div class="login-info">
        	<i class="home"></i>{{$site_name}}&nbsp;&nbsp;欢迎来到！
            	
        	      <a href="/login" class="login">请登录</a><a href="/zhuce">免费注册</a>
                
        </div>
    @else
       <div class="login-info"> 欢迎回来 , {{$user_name->username}} ！<a href="/quit/{{$user_name->id}}" class="login">退出</a> </div>
    @endif
        <ul class="login-menu">
        	<li><a href="/user/order/index.html">我的订单</a></li>
            <li class="line"></li>
		                <li> <a href="/user/index/login.html" class="login">我的特产</a>        
            <li class="line"></li>
           <!--  <li><a href="/user/info/inde.html">特产会员</a></li> -->
            <li class="line"></li>
            <li><a href="/help/index/showpage.html?t=客户服务"><i class="heart"></i>客户服务</a></li>
            <li class="line"></li>
            <li class="last"><em><a href="/user/supply/index.html">供应商入驻通道</a></em><i class="phone"></i>联系电话0595-22891399</li>
        </ul>
    </div>
</div>
<!--头部搜索-->
<div id="header">
	<div class="main">
        <h1><a title="蘑菇云-两岸特产网" href="/"></a></h1>
        <div class="searbox">
        	<div class="search-input">
            <form onSubmit="" method="get" target="_blank"  action="/serch">
                <input type="submit" value="搜特色" class="btn"/>
                <div class="control-box"><input type="text" id="keyword"  name="keyword" class="form-control inpt" placeholder="搜索 两岸特色" value=""></div>
            </form>
            </div>
        	<p class="hot-query">
        	<a target="_blank" title="茶叶" href="/serch?keyword=茶叶">茶叶</a>|<a target="_blank" title="酒" href="/serch?keyword=酒">酒</a>|<a target="_blank" title="葡萄" href="/serch?keyword=葡萄">葡萄</a>|<a target="_blank" title="苹果" href="/serch?keyword=苹果">苹果</a>|
        	</p>
        </div>
        <div class="mycart"><a href="/shop/cart/index.html" title="我的购物车"><i></i>我的购物车</a><code>0</code></div>
        <div class="cl"></div>
    </div>
</div>
<!--导航-->
<div id="nav">
	<ul class="main clearfix">
    	<li class="active"><a href="/">首   页</a></li>
        <li><a href="/help/index/special.html?t=shopguide">开店指南</a></li>
        <li><a href="/user/supply/index.html">供应商入驻</a></li>
        <li><a href="/user">会员中心</a></li>
        <li><a href="/shop/cloud/index.html">云端产品库</a></li>
    </ul>
</div>
<!--地区-->
<div class="region m-bg">
	<div class="main clearfix">
    	<ul>
    	<li class="taiwan"><a href="/shop/product/province/province_name/台湾.html">台湾</a></li><li ><a href="/shop/product/province/province_name/安徽.html">安徽</a></li><li ><a href="/shop/product/province/province_name/北京.html">北京</a></li><li ><a href="/shop/product/province/province_name/重庆.html">重庆</a></li><li ><a href="/shop/product/province/province_name/广西.html">广西</a></li><li ><a href="/shop/product/province/province_name/甘肃.html">甘肃</a></li><li ><a href="/shop/product/province/province_name/广东.html">广东</a></li><li ><a href="/shop/product/province/province_name/贵州.html">贵州</a></li><li ><a href="/shop/product/province/province_name/湖南.html">湖南</a></li><li ><a href="/shop/product/province/province_name/黑龙江.html">黑龙江</a></li><li ><a href="/shop/product/province/province_name/湖北.html">湖北</a></li><li ><a href="/shop/product/province/province_name/河南.html">河南</a></li><li ><a href="/shop/product/province/province_name/河北.html">河北</a></li><li ><a href="/shop/product/province/province_name/海南.html">海南</a></li><li ><a href="/shop/product/province/province_name/江西.html">江西</a></li><li ><a href="/shop/product/province/province_name/江苏.html">江苏</a></li><li ><a href="/shop/product/province/province_name/吉林.html">吉林</a></li><li ><a href="/shop/product/province/province_name/辽宁.html">辽宁</a></li><li ><a href="/shop/product/province/province_name/宁夏.html">宁夏</a></li><li ><a href="/shop/product/province/province_name/青海.html">青海</a></li><li ><a href="/shop/product/province/province_name/山东.html">山东</a></li><li ><a href="/shop/product/province/province_name/上海.html">上海</a></li><li ><a href="/shop/product/province/province_name/陕西.html">陕西</a></li><li ><a href="/shop/product/province/province_name/山西.html">山西</a></li><li ><a href="/shop/product/province/province_name/四川.html">四川</a></li><li ><a href="/shop/product/province/province_name/内蒙古.html">内蒙古</a></li><li ><a href="/shop/product/province/province_name/天津.html">天津</a></li><li ><a href="/shop/product/province/province_name/新疆.html">新疆</a></li><li ><a href="/shop/product/province/province_name/西藏.html">西藏</a></li><li ><a href="/shop/product/province/province_name/云南.html">云南</a></li><li ><a href="/shop/product/province/province_name/浙江.html">浙江</a></li><li ><a href="/shop/product/province/province_name/福建.html">福建</a></li>
        </ul>
    </div>
</div>
<!------------公用头部 end------------>
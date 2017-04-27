<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="en">
<meta charset="UTF-8">
<title>蘑菇云-两岸特产网-分销商管理</title>
<link rel="stylesheet" href="/manager/css/bootstrap.min.css">
<link rel="stylesheet" href="/manager/css/base.css">
<link rel="stylesheet" href="/manager/css/main.css">
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript" src="/js/sea_config.js"></script>
<script charset="utf-8" async="" src="/js/jquery.min.js"></script>
<script charset="utf-8" async="" src="/js/product.js"></script>
<script charset="utf-8" async="" src="/js/product_Marquee.js"></script>
<script charset="utf-8" async="" src="/js/jqueryzoom.js"></script>
<script charset="utf-8" async="" src="/js/jquery.cookie.js"></script>
<script charset="utf-8" async="" src="/js/district.js"></script>

<body>
<!------------公用头部 start------------>
<div id="topnav">
  <div class="main clearfix">
    <div class="login-info"> 欢迎回来 , {{$user_name->username}} ！<a href="quit/{{$user_name->id}}" class="login">退出</a> </div>
    <ul class="login-menu">
      <li><a href="#">联系客服</a></li>
      <li class="line"></a></li>
      <li><a href="/help/index/index.html">帮助中心</a></li>
    </ul>
  </div>
</div>
<!--头部-->
<div id="header">
  <div class="main">
    <h1><a title="特产网" href="/"></a></h1>
  </div>
</div>
<div id="nav">
  <div class="main clearfix fs-16 text-white"> <i></i> 我的电商分销平台 </div>
</div>
<!------------公用头部 end------------>
<link type="text/css" rel="stylesheet" href="/statics/index/css/user_center.css" />

<!------------主体 start------------>
<div class="main">
<!--左侧导航  start-->
<div class="main-left fl fs-14 clearfix">

    <h3 class="item fs-14"><i class="myhome"></i>我的微店铺	</h3>
    <ul>
      <li><a href="/user/seller/index.html"><i class="ico-1"></i>分销商管理</a></li>
      <li><a href="/user/cloud/index.html"><i class="ico-2"></i>微店产品库</a></li>
      <li><a href="/user/order/index.html"><i class="ico-3"></i>订单管理</a></li>
      <li><a href="/user/product_list"><i class="ico-4"></i>我的供应</a></li>
      <li><a href="/user/auth/index.html"><i class="ico-16"></i>我的认证</a></li>
      <li><a href="/user/auth/authsupply.html"><i class="ico-16"></i>供应商认证</a></li>
      <div class="cl"></div>
    </ul>
    <!--
          <li><a href="shop.html"><i class="ico-1"></i>分销商管理</a></li>
      <li><a href="shop-1.html"><i class="ico-2"></i>云端产品库</a></li>
      <li><a href="shop-2.html"><i class="ico-3"></i>订单管理</a></li>
      <li><a href="shop-3.html"><i class="ico-4"></i>我的供应</a></li>


      user/supply_publish/index
      user/supply_order/index
      user/supply_info/qq
      user/supply_info/address
     -->

<!--     <h3 class="item fs-14"><i class="ydh"></i>我的广告</h3>
    <ul >
      <li><a href="/user/nav/index.html"><i class="ico-5"></i>导航能赚钱</a></li>
      <li><a href="/user/nav/position.html"><i class="ico-6"></i>我要拍位置</a></li>
    </ul> -->
    <h3 class="item fs-14"><i class="money"></i>财富中心</h3>
    <ul>
      <li><a href="/user/money/index.html"><i class="ico-7"></i>余额动态</a></li>
      <li><a href="/user/tradecom/index.html"><i class="ico-8"></i>我的佣金</a></li>
      <li><a href="/user/auth_com/index.html"><i class="ico-8"></i>认证佣金</a></li>

      <li><a href="/user/return/index.html"><i class="ico-9"></i>购物退款</a></li>
      <li><a href="/user/supply_money/index.html"><i class="ico-10"></i>货物管理</a></li>
      <li><a href="/user/supply_deposit/index.html"><i class="ico-11"></i>供应商保证金</a></li>
    </ul>
    <h3 class="item fs-14"><i class="person"></i>个人资料</h3>
    <ul>
      <li><a href="/user/info/index.html"><i class="ico-12"></i>基本资料</a></li>
      <li><a href="/user/info/password.html"><i class="ico-13"></i>修改密码</a></li>
      <li><a href="/user/info/bank.html"><i class="ico-14"></i>银行信息</a></li>
      <li><a href="/user/info/address.html"><i class="ico-15"></i>收货信息</a></li>

      <!--
            <li><a href="person.html"><i class="ico-12"></i>基本资料</a></li>
      <li><a href="person-1.html"><i class="ico-13"></i>修改密码</a></li>
      <li><a href="person-2.html"><i class="ico-14"></i>银行信息</a></li>
      <li><a href="person-3.html"><i class="ico-15"></i>收货信息</a></li>
       -->
    </ul>
    <h3 class="item fs-14"><i class="ydpro"></i><a href="/shop/cloud/index.html">云端产品库</a></h3>
  </div>



  <!--左侧导航  end-->

  <div class="main-right fr clearfix">
    <div class="content">
    <!--云导航 shop-->
	  <div class="myshop clearfix">
        <div class="management clearfix">
        <div class="management-1">
        	<h1>分销商管理</h1>


        <table class="table table-bordered">
                  <thead>

                    <tr>
                      <th>序号</th>
                      <th>分销商</th>
                      <th>QQ</th>
                      <th>加盟日期</th>
                      <th>他的成交佣金总额</th>
                      <th>他为您带来的佣金</th>
                      <th>所在城市</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                     </tbody>
            </table>
      	 </div>
        	        	                 <div class="pagelist">
                        	                        </div>
        <div class="management-2 clearfix">
        <h1 class="text-cred">一键推广微店，让分销商加盟：</h1>
       	<div class="cloud-tip clearfix">
              	<div class="tip1 fl" id="tips">我刚开了微店，跪求人气，来访我网店者，每人送一个礼品http://13959823003.okmgy.com</div>
              	<textarea class="CIndiInnerR-conB1-t2Text" id="copy_text" style="display:none;">我刚开了微店，跪求人气，来访我网店者，每人送一个礼品:http://13959823003.okmgy.com</textarea>
                <div class="tip1-copy fl">
       			<a class="btn btn-red btn-lg" id="copy_btn" href="javascript:void(0)">复制内容</a>
                <a class="btn btn-red  btn-lg" id="ewm_btn" href="#ewmModal" data-toggle="modal" >二维码</a>
                <p>复制后粘贴到QQ群、QQ、微博、博客、论坛、或者通过邮件，均可推广！点击此链接进入你微店的访客，会自动成为你的分销商！</p>
                </div>
                <div id="code"></div>
                <div class="cl"></div>
          </div>
          </div>

           <div class="management-3 clearfix">
                <h1 class="text-cred">微店推广攻略：</h1>
                <ul>
                <li class="fl"><a href="###"> · 向身边的人推广微店</a></li>
				<li class="fl"><a href="###"> · 分享推广</a></li>
                <li class="fl"><a href="###"> · 向身边的人推广微店</a></li>
                <li class="fl"><a href="###"> · 利用QQ推广微店</a></li>
                <li class="fl"><a href="###"> · 博客推广</a></li>
                <li class="fl"><a href="###"> · O2O平台免费推广</a></li>
                </ul>
         	 </div>
          </div>
        </div>
    <!--云导航 shop-->

   	</div>
  </div>
  <div class="cl"></div>
</div>

<!--二维码弹窗 start -->
<div class="modal fade" id="ewmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
  	<span data-dismiss="modal" class="review_close"></span>
    <div class="modal-content">
      <div class="modal-body">
        <script type="text/javascript">var _qrContent='http://13959823003.okmgy.com',_qrLogo='',_qrWidth=100,_qrHeight=100,_qrType = 'auto';document.write(unescape("%3Cscript src='http://qrcode.leipi.org/js.html?qw="+_qrWidth+"&qh="+_qrHeight+"&qt="+_qrType+"&qc="+escape(_qrContent)+"&ql="+escape(_qrLogo)+"' type='text/javascript'%3E%3C/script%3E"));</script>
      </div>
    </div>
  </div>
</div>
<!--二维码弹窗end -->

<script type="text/javascript">
seajs.use(['app'], function(app) {
    app.copyToClipBoard('copy_btn','copy_text');
});
</script>
<!------------主体 end------------>

<script type="text/javascript" src="/manager/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/manager/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/manager/js/common.js"></script>
<script language="javascript">
function copyToClipBoard(){
var tip = $('#tips');
var clipBoardContent="";
clipBoardContent+="\n";
clipBoardContent+=tip.html();
window.clipboardData.setData("Text",clipBoardContent);
alert("复制后粘贴到QQ群、QQ、微博、博客、论坛、或者通过邮件，均可推广！点击此链接进入你微店的访客，会自动成为你的分销商！！");
}


$(function(){

	var Url='/User/Seller/index.html';
	$("[href='/User/Seller/index.html']").addClass('active');



	$(".main-left").find("a").each(function(){
	if($(this).attr("href").replace("_","")==Url.toLowerCase()){
		$(this).addClass('active');
		$(this).parent().parent().addClass('on');

	}

	});

});
</script>
</body>
</html>
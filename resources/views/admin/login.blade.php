
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{$title}}</title>
	<meta name="keywords" content="蘑菇云"/>
	<meta name="description" content="蘑菇云"/>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/login.css">
    <script type="text/javascript" src="/js/sea.js"></script>
	<script type="text/javascript" src="/js/sea_config.js"></script>
<body>
<!------------公用头部 start------------>
<!--头部搜索-->
<div id="header">
	<div class="main">
        <h1><a title="蘑菇云-两岸特产网" href="http://www.两岸特产.com"></a></h1>
        <div class="cl"></div>
    </div>
</div>
<!------------公用头部 end------------>

<div id="login-bg" style="background-image:url(/img/login-bg.jpg)">
	<div class="main clearfix">
    	<div class="box">
        	<div class="con">
            	<h2>账户登录</h2>
                <form class="form-horizontal" method="post" action="/admin/login">
               		 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="form-group border">
                    <div class="control-label"><i class="name-ico"></i></div>
                    <div class="control-inpt">
                        <input type="text" class="form-control" name="username" id="username" placeholder="昵称/微店号/手机号" value="{{$username}}">
                    </div>
                  </div>
                  <div class="form-group border">
                    <div class="control-label"><i class="pass-ico"></i></div>
                    <div class="control-inpt">
                        <input type="password" class="form-control" name="password" id="password" placeholder="请输入密码">
                    </div>
                  </div>
                  <p class="help-block text-black" id="error_tips">{{$error}}</p >
                  <div class="form-group">
                    <div class="checkbox">
                    <label><input type="checkbox" name="is_save" value="30" class="uncheck_agreement"> 记住登录状态</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-lg btn-block btn-red">登 录</button>
                  <div class="btlink"><a href="/user/index/register.html" class="pull-right">免费注册</a><a href="/user/index/forgetpassword.html">忘记登陆密码？</a></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
seajs.use(['app','user'], function(app,user) {
    $('.btn-red').click(function() {
        user.login($('#login_form'));
    });
   $(document).keydown(function(event){
      if(event.keyCode == 13) {
        $('.btn-red').click();
      }
   });
});
</script>

<!------------公用底部 start------------>
<div id="footer">
<div class="m-bg ensure">
    	<ul class="main clearfix">
            <li>
            	<a href="javascript:void(0)">
                <i></i>
                <h4>品质保障</h4>品质护航 购物无忧
                </a>
            </li>
            <li class="li2">
            	<a href="javascript:void(0)">
                <i></i>
                <h4>7天无理由退换</h4>为您提供售后无忧保障
                </a>
            </li>
            <li class="li3">
                <a href="javascript:void(0)">
                <i></i>
                <h4>特色服务体验</h4>为您呈现不一样的服务
                </a>
            </li>
            <li class="li4">
            	<a href="javascript:void(0)">
                <i></i>
                <h4>帮助中心</h4>
                </a>
            </li>
        </ul>
    </div>
    <div class="main">
    	<div class="server">
        	<dl>
            	<dt>关于我们</dt>
                <dd><a href="/help/index/showpage.html?t=关于我们">关于我们</a></dd>
                <dd><a href="/help/index/showpage.html?t=企业文化">企业文化</a></dd>
                <dd><a href="/help/index/showpage.html?t=联系我们">联系我们</a></dd>
            </dl>
            <dl>
            	<dt>新手指南</dt>
                <dd><a href="/help/index/showpage.html?t=注册">注册</a></dd>
                <dd><a href="/help/index/showpage.html?t=开店指南">开店指南</a></dd>
                <dd><a href="/help/index/showpage.html?t=供应商入驻">供应商入驻</a></dd>
            </dl>
            <dl>
            	<dt>平台保障</dt>
                <dd><a href="/help/index/showpage.html?t=严格准入制度">严格准入制度</a></dd>
                <dd><a href="/help/index/showpage.html?t=调解中心">调解中心</a></dd>
                <dd><a href="/help/index/showpage.html?t=资金安全">资金安全</a></dd>
            </dl>
            <dl class="last">
            	<dt>会员服务</dt>
                <dd><a href="/help/index/showpage.html?t=会员政策">会员政策</a></dd>
                <dd><a href="/help/index/showpage.html?t=会员级别">会员级别</a></dd>
                <dd><a href="/help/index/showpage.html?t=服务中心">服务中心</a></dd>
            </dl>
            <div class="hotline">
            	<p>服务 时间：上午9:00——下午10:00</p>
                <p>周末/假日：上午10:00——下午6:00</p>
            </div>
        	<div class="cl"></div>
        </div>
    	<div class="copyright">
    	Copyright©2014 蘑菇云  地址：福建泉州市丰泽区东海大街东海湾中心一号楼1502  电话：0595-22891399  经营许可证：闽ICP备15025789号-1    	</div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!------------公用底部 end------------>
</body>
</html>
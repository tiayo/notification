<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/jquery.js"></script>
<script type="text/javascript">
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>

</head>

<body style="background:url(/images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="/" target="_blank"><img src="/images/logo.png" title="系统首页" /></a>
    </div>
        
    <ul class="nav">
    <li><a href="/liebiao" target="rightFrame">内容列表</a></li>
    </ul>
            
    <div class="topright">    
    <ul>
    <li><a href="/" target="_blank">返回首页</a></li>
    <li><span><img src="/images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    <li><a href="/quit?id={{$user_id}}" target="_parent">退出</a></li>
    </ul>
     
    <div class="user">
    <span>{{$user_name->username}}</span>
    <i>消息</i>
    <b><a href="/Admin/Index/liuyan" target="rightFrame"><div id="shuchu" style="color:#fff;">0</div></a></b>
    </div>    
    
    </div>

</body>
</html>

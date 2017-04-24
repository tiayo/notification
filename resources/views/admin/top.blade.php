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
//$(document).ready(function(){
		  setTimeout(function() {
             Push();
           },
        200);
      /*30轮询读取函数*/
        setInterval(function() {
            Push();
    },
        5000);
/*请求函数的ajax*/
function Push() {
		$.ajax({ 
		type: "post", 
		url: "/index/liuyan_ajax", 
		dataType: "json",
		success: function (data) { 
		   shuchu = data;
		   $("#shuchu").html(shuchu);
		}, 
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			  //alert('ajax刷新异常，错误：'+errorThrown); 
		}
		
	   
		});
}
</script>

<meta name="__hash__" content="fd5791137041869e9bd380db3fc57b62_e0245253755620bd9acd2af5210055b6" /></head>

<body style="background:url(/images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="/" target="_blank"><img src="/images/logo.png" title="系统首页" /></a>
    </div>
        
    <ul class="nav">
        <li><a href="/index/right" target="rightFrame">我的任务</a></li>
        <li><a href="/list/admin_list?id=1" target="rightFrame">添加任务</a></li>
    </ul>
            
    <div class="topright">    
    <ul>
    <li><a href="/" target="_blank">返回首页</a></li>
    <li><span><img src="/images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    <li>
        <form method="post" action="/logout" target="_parent">
            {{ csrf_field() }}
            <input class="logout" type="submit" name="logout" value="退出"/>
        </form>
    </li>
    </ul>
     
    <div class="user">
    <span>admin</span>
    <i>消息</i>
    <b><a href="/Index/liuyan" target="rightFrame"><div id="shuchu" style="color:#fff;">0</div></a></b>
    </div>    
    
    </div>

</body>
</html>
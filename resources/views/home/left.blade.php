<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>
<style type="text/css">
body,td,th {
	font-family: "Microsoft YaHei";
}
</style>
</head>

<body style="background:#f0f9fd;">
<div class="lefttop"><span></span>随享社区</div>
    
    <dl class="leftmenu">
        
    <dd>
    <div class="title">
    <span><img src="/images/leftico01.png" /></span>采集设置
    </div>
    	<ul class="menuson">
        <li class="active"><cite></cite><a href="/set_jiben" target="rightFrame">基本设置</a><i></i></li>
        <li><cite></cite><a href="/set_gaoji" target="rightFrame">高级设置</a><i></i></li>
        </ul>    
    </dd>

    <dd>
    <div class="title">
    <span><img src="/images/leftico02.png" /></span>采集规则
    </div>
    <ul class="menuson">
		<foreach name='mingcheng_list' item='mingcheng_list'> 
        <li class="active"><cite></cite><a href="/guize_add" target="rightFrame">新增采集规则</a><i></i></li>
        <li><cite></cite><a href="/guize_list" target="rightFrame">规则列表</a><i></i></li>
       </foreach> 
    </ul>     
    </dd> 

    <dd>
    <div class="title">
    <span><img src="/images/leftico02.png" /></span>内容列表
    </div>
    <ul class="menuson">
		<foreach name='mingcheng_list' item='mingcheng_list'> 
        <li><cite></cite><a href="/liebiao" target="rightFrame">内容列表</a><i></i></li>
       </foreach> 
    </ul>     
    </dd> 

    </dl>
    
</body>
</html>

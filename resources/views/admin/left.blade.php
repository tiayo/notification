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

<meta name="__hash__" content="815142ad9273ac3ba118b76c71290b15_10ad3c33ec7aff3f1ccd9f9dd44d0764" /></head>

<body style="background:#f0f9fd;">
<div class="lefttop"><span></span>随享社区</div>
    
    <dl class="leftmenu">
        
    <dd>
    <div class="title">
    <span><img src="/images/leftico01.png" /></span>我的任务
    </div>
    	<ul class="menuson">
            <li class="active"><cite></cite><a href="/admin/task/page" target="rightFrame">我的任务</a><i></i></li>
            <li><cite></cite><a href="/admin/task/add" target="rightFrame">添加任务</a><i></i></li>
        </ul>
    </dd>

    @if ($admin === true)
    <dd>
        <div class="title">
            <span><img src="/images/leftico02.png" /></span>管理操作
        </div>
        <ul class="menuson">
            <li class="active"><cite></cite><a href="/admin/category/page/1" target="rightFrame">管理分类</a><i></i></li>
            <li><cite></cite><a href="#" target="rightFrame">预留位置</a><i></i></li>
        </ul>
    </dd>
    @endif

   </dl>
    
</body>
</html>
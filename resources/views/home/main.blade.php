<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/jquery.js"></script>
<style type="text/css">
body,td,th {
	font-family: "Microsoft YaHei";
}
</style>
</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="./main">随享采集系统后台</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="/images/sun.png" alt="天气" /></span>
    <b>{{$user_xinxi->username}}你好，欢迎登录到随享采集系统</b>(版本：1.0)
    </div>
    
    <div class="welinfo">
    <span><img src="/images/time.png" alt="时间" /></span>
    <i>您上次登录的时间:{{date("Y-m-d H:i:s",$user_xinxi->nextlogintime)}}</i> （不是您登录的？<a href="/Admin/Registed/xiugai_mima">请点这里</a>）
    </div>
    
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="/images/dp.png" alt="提醒" /></span>
    <b>“随享”校园社区快捷操作</b>
    </div>
    
    <ul class="infolist">
    <li><span>使用祥景CMS 快速管理文章</span><a href="/admin/index/right" class="ibtn">管理我的分享</a></li>
    <li><span>传张头像会让你魅力大增拍！</span><a href="/Admin/Registed/xiugai_ziliao" class="ibtn">修改我的资料</a></li>
    <li><span>定期修改“随享”社区账号密码</span><a href="/Admin/Registed/xiugai_mima" class="ibtn">修改密码</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="uimakerinfo"><b>全站刚上新的资源</b></div>
    
    <ul class="umlist">
   <foreach name='new_content'  item='row'>
   		<li><a href="/article.php?aid={$row[aid]}" target="_blank">{$row[title]}</a></li>
   </foreach> 

    </ul>
    
    
    </div>
    
<div class="banquan"></div>   
</body>

</html>

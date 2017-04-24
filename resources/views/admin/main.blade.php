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
<meta name="__hash__" content="474c1e97673dfc9fe072d1a3dfdd8219_206c01877b82380e9809b6e98608928a" /></head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="/admin/main">首页-{{config('site.site_title')}}</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="/images/sun.png" alt="天气" /></span>
    <b>超级管理员你好，欢迎登录到{{config('site.site_title')}}</b>(版本：{{config('site.version')}})
    </div>
    
    <div class="welinfo">
    <span><img src="/images/time.png" alt="时间" /></span>
    <i>您上次登录的时间:{{$next_login_time}}</i> （不是您登录的？<a href="/Registed/xiugai_mima">请点这里</a>）
    </div>
    
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="/images/dp.png" alt="提醒" /></span>
    <b>"随享"校园社区快捷操作</b>
    </div>
    
    <ul class="infolist">
    <li><span>使用祥景CMS 快速管理文章</span><a href="/index/right" class="ibtn">管理我的分享</a></li>
    <li><span>传张头像会让你魅力大增拍！</span><a href="/Registed/xiugai_ziliao" class="ibtn">修改我的资料</a></li>
    <li><span>定期修改"随享"社区账号密码</span><a href="/Registed/xiugai_mima" class="ibtn">修改密码</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="uimakerinfo"><b>全站刚上新的资源</b></div>
    
    <ul class="umlist">
   <li><a href="/article.php?aid=57" target="_blank">linux备忘录</a></li><li><a href="/article.php?aid=58" target="_blank">自建MVC框架</a></li><li><a href="/article.php?aid=59" target="_blank">使用txt文本作为数据库</a></li><li><a href="/article.php?aid=60" target="_blank">添加图片水印（透明添加）</a></li><li><a href="/article.php?aid=61" target="_blank">（自写）正则邮箱地址过滤</a></li><li><a href="/article.php?aid=62" target="_blank">php自带函数处理图片</a></li> 

    </ul>
    
    
    </div>
    
<div class="banquan"></div>   
</body>

</html>
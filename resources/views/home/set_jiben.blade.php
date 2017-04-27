<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<link href="/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/jquery.js"></script>
<script type="text/javascript" src="/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/select-ui.min.js"></script>
<script type="text/javascript">
    KE.show({
        id : 'content7',
        cssPath : '/index.css'
    });
  </script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">基本设置</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
  	<ul> 
    <li><a href="#tab1" class="selected">基本设置</a></li> 
  	</ul>
    </div> 
    
  	<div id="tab1" class="tabson">
    


<form method="post" action="/set_jiben_chuli">   
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
    <ul class="forminfo"> 
<!--招聘页面-->
        <div id="xinxi_zhaoping" class="xinxi_zhaoping">    
            <li><label>数据表名<b>*</b></label><input name="shujubiao" type="text" class="dfinput" value="{{$set->shujubiao or null}}" placeholder="输入您的文章数据库表名" style="width:518px;"/></li>  
            <li><label>抓取条数<b>*</b></label><input name="tiaoshu" type="text" class="dfinput" value="{{$set->tiaoshu or null}}" placeholder="输入运行一次要抓取多少文章" style="width:518px;"/></li>  
            <li><label>默认作者<b>*</b></label><input name="zuozhe" type="text" class="dfinput" value="{{$set->zuozhe or null}}" placeholder="输入要显示的作者" style="width:518px;"/></li>  
            <li><label>默认来源<b>*</b></label><input name="laiyuan" type="text" class="dfinput" value="{{$set->laiyuan or null}}" placeholder="输入要显示的来源" style="width:518px;"/></li>  
            <li><label>数据字段<b>*</b></label><textarea name="ziduan" style="width:345px; height:150px; padding:5px;" onClick="if(this.value=='用|分隔'){this.value='';}">{{$set->ziduan or '用|分隔'}}</textarea></li>
            <li><label>内容过滤<b>*</b></label><textarea name="guolv" style="width:345px; height:150px; padding:5px;" onClick="if(this.value=='多个请用‘|’分隔 如：神马|{给力}'){this.value='';}">{{$set->guolv or '多个请用‘|’分隔 如：神马|{给力}'}}</textarea></li>
            <li><label>文章链接<b>*</b></label><input name="lianjie" type="text" class="dfinput" value="{{$set->lianjie or null}}" placeholder="输入链接模板，动态部分使用(*)代替" style="width:518px;"/></li>  
            <li><label>链接字段<b>*</b></label><input name="lianjie_ziduan" type="text" class="dfinput" value="{{$set->lianjie_ziduan or null}}" placeholder="这里是定义替换(*)的数据出于哪个字段，比如：aid" style="width:518px;"/></li>  
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="提交设置"/></li>
        </div>
    </ul>
</form>

    </div> 
    
           
	</div> 
 
	<script type="text/javascript"> 
      $("#usual1 ul").idTabs(); 
    </script>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
    
    
    
    
    
    </div>


</body>

</html>
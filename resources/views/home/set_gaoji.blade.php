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
    <li><a href="#">高级设置</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
  	<ul> 
    <li><a href="#tab1" class="selected">高级设置（设置对应数据库字段）</a></li> 
  	</ul>
    </div> 
    
  	<div id="tab1" class="tabson">
    


<form method="post" action="/set_gaoji_chuli">   
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
    <ul class="forminfo"> 
<!--招聘页面-->
        <div id="xinxi_zhaoping" class="xinxi_zhaoping">    
        	@foreach($ziduan_shuchu as $ziduan_shuchu)
            <li><label>{{$ziduan_shuchu['wenzi']}}<b>*</b></label><input name="{{$ziduan_shuchu['pinyin']}}" type="text" class="dfinput" value="{{$set_gaoji->$ziduan_shuchu['pinyin'] or null}}" placeholder="输入数据库'{{$ziduan_shuchu['wenzi']}}'对应的字段" style="width:518px;"/></li>  
            @endforeach
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
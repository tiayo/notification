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
    <li><a href="#">新增采集规则</a></li>
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
    


<form method="post" action="/guize_xiugai_tijiao?gusi_id={{$guize->gusi_id}}">   
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
    <ul class="forminfo"> 
<!--招聘页面-->
        <div id="xinxi_zhaoping" class="xinxi_zhaoping">
            <li><label>规则名称<b>*</b></label><input name="gusi_mingcheng" type="text" class="dfinput" value="{{$guize->gusi_mingcheng}}" placeholder="输入规则名称" style="width:518px;"/></li>
            <li><label>域名<b>*</b></label><input name="gusi_yuming" type="text" class="dfinput" value="{{$guize->gusi_yuming}}" placeholder="输入采集网站的域名。加上http://" style="width:518px;"/></li>
            <li><label>列表url<b>*</b></label><input name="gusi_liebiao" type="text" class="dfinput" value="{{$guize->gusi_liebiao}}" placeholder="输入列表url,(*)为通配符" style="width:518px;"/></li>  
            <li><label>文章url<b>*</b></label><input name="gusi_wenzhang" type="text" class="dfinput" value="{{$guize->gusi_wenzhang}}" placeholder="输入文章url,(*)为通配符" style="width:518px;"/></li>  
            @if($guize->gusi_leixing == 1)
            <li style="line-height:37px;"><label>链接类型<b>*</b></label><input name="gusi_leixing" type="radio" value="1" checked/>带域名&emsp;<input name="gusi_leixing" type="radio" value="2"/>不带域名</li>
            @else
            <li style="line-height:37px;"><label>链接类型<b>*</b></label><input name="gusi_leixing" type="radio" value="1"/>带域名&emsp;<input name="gusi_leixing" type="radio" value="2" checked/>不带域名</li>
            @endif
            @if($guize->gusi_bianma == 1)
            <li style="line-height:37px;"><label>页面编码<b>*</b></label><input name="gusi_bianma" type="radio" value="1" checked/>UTF-8&emsp;<input name="gusi_bianma" type="radio" value="2"/>GBK</li>
            @else
            <li style="line-height:37px;"><label>页面编码<b>*</b></label><input name="gusi_bianma" type="radio" value="1"/>UTF-8&emsp;<input name="gusi_bianma" type="radio" value="2" checked/>GBK</li>
            @endif
            @foreach($ziduan as $ziduan)
            <li><label>{{$ziduan['wenzi']}}<b>*</b></label><textarea name="{{$ziduan['pinyin']}}" style="width:345px; height:150px; padding:5px;">{{$guize->$ziduan['pinyin'] or null}}</textarea></li>
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
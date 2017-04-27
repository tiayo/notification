<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>
<script>
$(document).ready(function(){
	//全选
	$('#quanxuan').click(function(){
	  panduan = $("#quanxuan").prop("checked");
	  if(panduan == true){
		  $("input").prop("checked", 'checked');
	  }else{
		  $("input").prop("checked", false);
	}
  })
})
</script>
<script>
//采集中提示框
function zhixing(){
	$('#caijizhong').css('display','block');
	$('#caijizhong i').animate({marginLeft:"68%"},2000);
	$('#caijizhong i').animate({marginLeft:"2%"},2000);
	setTimeout("zhixing()",10);
}
$(document).ready(function(){
	$('.tablelist #zhixing').click(function(){
		setTimeout("zhixing()",10);
	})
})
</script>
</head>


<body>
<div id="caijizhong" style="display:none;">
    <p>采集中</p>
    <i></i>
    <span>可能需要几分钟的时间，请耐心等待...</span>
</div>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">内容列表</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li><a href="/guize_add"><span><img src="/images/t01.png" /></span>添加</a></li>
        <li><span><img src="/images/t02.png" /></span>修改</li>
        <li class="click"><span><img src="/images/t03.png" /></span>删除</li>
        </ul>
        
        
        <ul class="toolbar1">
            <li class="paginItem"><a href="?tid={{$page_pre}}">上一页</a></li>
            @if(!empty($fenye_li))
		    @foreach($fenye_li as $fenye)
		         	{!! $fenye !!}
		    @endforeach
            @endif
   			<if condition="$yeshu EGT 5">  
                <li class="paginItem">
                    <select class="lanmu" onchange="window.location=this.value;">
                        <option value="">更多</option>
                        @if(!empty($fenye_2))
                        @foreach($fenye_2 as $fenye_two)
		         			{!! $fenye_two !!}
		    			@endforeach
                        @endif
                    </select>
                </li>
            </if>
	        <li class="paginItem"><a href="?tid={{$page_next}}">下一页</a></li>
		</ul>
    
    </div>
    

   
<form method="post" action="/guize_delete_piliang">  
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="checkbox101" type="checkbox" value="101"  id="quanxuan"/></th>
        <th>编号</th>
        <th>名称</th>
        <th>列表URL</th>
        <th>文章URL</th>
        <th>类型</th>
        <th>编码</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($wenzhang as $wenzhang)
		<tr>
        <td><input name="xuanze[]" value="{{$wenzhang->gusi_id}}" type="checkbox" id="xuanze"/></td>
        <td>{{$wenzhang->gusi_id}}</td>
        <td>{{$wenzhang->gusi_mingcheng}}</td>
        <td>{{$wenzhang->gusi_liebiao}}</td>
        <td>{{$wenzhang->gusi_wenzhang}}</td>
        <td>
        @if($wenzhang->gusi_leixing == 2)
        不带域名
        @else
        带域名
        @endif
        </td>
        <td>
        @if($wenzhang->gusi_bianma == 2)
        GBK
        @else
        UTF-8
        @endif
        </td>
        <td><a id="zhixing" href="/guize_zhixing?gusi_id={{$wenzhang->gusi_id}}">执行</a>&emsp;<a href="/guize_delete?gusi_id={{$wenzhang->gusi_id}}">删除</a>&emsp;<a href="/guize_xiugai?gusi_id={{$wenzhang->gusi_id}}">修改</a></td>
        </tr> 
        @endforeach
        </tbody>
    </table>
    
   
    <div class="pagin">
    	<div class="message">共<i class="blue">{{$num_article}}</i>条记录，当前显示第<i class="blue">{{$page}}</i>页</div>
        <ul class="paginList">    
	        <li class="paginItem"><a href="?tid={{$page_pre}}">上一页</a></li>
            @if(!empty($fenye_li))
		    @foreach($fenye_li as $fenye)
		         	{!! $fenye !!}
		    @endforeach
            @endif
   			<if condition="$yeshu EGT 5">  
                <li class="paginItem"><a>
                    <select class="lanmu" onchange="window.location=this.value;">
                      <option value="">更多</option>
                        @if(!empty($fenye_2))
                        @foreach($fenye_2 as $fenye_2)
		         			{!! $fenye_2 !!}
		    			@endforeach
                        @endif
                    </select>
                </a></li>
   			</if>  
	        <li class="paginItem"><a href="?tid={{$page_next}}">下一页</a></li>
        </ul>
    </div>
    
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="/images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
      </div>
        
        <div class="tipbtn">
        <input name="submit" type="submit"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
</form>    
    </div>
<script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
</body>
</html>

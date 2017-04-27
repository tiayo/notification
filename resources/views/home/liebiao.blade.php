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
</head>


<body>

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
        <li><a href="/Admin/list/xinxi_view?id=1"><span><img src="/images/t01.png" /></span>添加</a></li>
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
				@if(!empty($fenye_2))
                <li class="paginItem">
                    <select class="lanmu" onchange="window.location=this.value;">
                        <option value="">更多</option>
                        @foreach($fenye_2 as $fenye_two)
		         			{!! $fenye_two !!}
		    			@endforeach
                    </select>
                </li>
			@endif
	        <li class="paginItem"><a href="?tid={{$page_next}}">下一页</a></li>
		</ul>
    
    </div>
    

   
<form method="post" action="/admin/index/article_delete_duo">    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="checkbox101" type="checkbox" value="101"  id="quanxuan"/></th>
        @foreach($ziduan as $ziduan_wenzi)
        <th>{{$ziduan_wenzi['wenzi']}}</th>
        @endforeach
        <th>查看</th>
        </tr>
        </thead>
        <tbody>
       @foreach($wenzhang as $wenzhang)
		<tr>
        <td><input name="xuanze" value="" type="checkbox" id="xuanze"/></td>
        	@for ($i = 0; $i < 8; $i++)
        	<td>
			  @if (strlen($wenzhang['xinxi']->$ziduan_shiji_arr[$i]) > 100)
              	内容过长不显示
              @else
                {{$wenzhang['xinxi']->$ziduan_shiji_arr[$i]}}
              @endif
            </td>
       		@endfor
            <td><a href="{{$wenzhang['url']}}" target="_blank">查看文章</a></td>
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
				@if(!empty($fenye_2))
                <li class="paginItem"><a>
                    <select class="lanmu" onchange="window.location=this.value;">
                      <option value="">更多</option>
                        @foreach($fenye_2 as $fenye_2)
		         			{!! $fenye_2 !!}
		    			@endforeach
                    </select>
                </a></li>
				@endif
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

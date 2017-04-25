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
    <li><a href="#">分类管理</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li><a href="/admin/category/add"><span><img src="/images/t01.png" /></span>添加</a></li>
        <li><span><img src="/images/t02.png" /></span>修改</li>
        <li class="click"><span><img src="/images/t03.png" /></span>删除</li>
        </ul>
        
        
        <ul class="toolbar1">
            <li class="paginItem"><a href="{{($page-1) < 1 ? 1 : ($page-1)}}">上一页</a></li>
		    @for ($i=1;$i<=$count;$i++)
                <li class="paginItem"><a href="{{$i}}">第{{$i}}页</a></li>
		    @endfor
   			@if ($max_page > 5)
                <li class="paginItem">
                    <select class="lanmu" onchange="window.location=this.value;">
                        <option value="">更多</option>
                        @for ($i=6;$i<=$max_page;$i++)
                            <option value="{{$i}}">第{{$i}}页</option>
                        @endfor
                    </select>
                </li>
            @endif
	        <li class="paginItem"><a href="{{($page+1) > $max_page ? $max_page : $page+1}}">下一页</a></li>
		</ul>
    
    </div>
    

   
<form method="post" action="/admin/index/article_delete_duo">    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="checkbox101" type="checkbox" value="101"  id="quanxuan"/></th>
        <th>编号<i class="sort"><img src="/images/px.gif" /></i></th>
        <th>名称</th>
        <th>父级</th>
        <th>别名</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list_category as $row)
            <tr>
                <td><input name="xuanze{++$i}" value="{$row[aid]}" type="checkbox" id="xuanze"/></td>
                <td>{{$row['id']}}</td>
                <td>{{$row['name']}}</td>
                <td>{{$row['parent_name']}}</td>
                <td>{{$row['alias'] or ''}}</td>
                <td>{{$row['created_at']}}</td>
                <td>{{$row['updated_at']}}</td>
                <td>
                    <a href="/admin/index/article_xiugai?aid={$row[aid]}" class="tablelink">设置</a>
                    <a href="/admin/index/article_delete?delete={$row[aid]}" class="tablelink"> 删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
   
    <div class="pagin">
    	<div class="message">共<i class="blue">{{$count}}</i>条记录，当前显示第<i class="blue">{{$page}}</i>页</div>
        <ul class="paginList">
            <li class="paginItem"><a href="{{($page-1) < 1 ? 1 : ($page-1)}}">上一页</a></li>
            @for ($i=1;$i<=$count;$i++)
                <li class="paginItem"><a href="{{$i}}">第{{$i}}页</a></li>
            @endfor
            @if ($max_page > 5)
                <li class="paginItem">
                    <select class="lanmu" onchange="window.location=this.value;">
                        <option value="">更多</option>
                        @for ($i=6;$i<=$max_page;$i++)
                            <option value="{{$i}}">第{{$i}}页</option>
                        @endfor
                    </select>
                </li>
            @endif
            <li class="paginItem"><a href="{{($page+1) > $max_page ? $max_page : $page+1}}">下一页</a></li>
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

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
        $("#judge").val('delete');
        $("#selectEvent").submit();
    });
    $("#modified").click(function(){
        $("#judge").val('modified');
        if ($("input:checked").length == 1) {
            $("#selectEvent").submit();
        } else {
            alert('只能且必须选中一个产品');
        }
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
    <li><a href="#">订单管理</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
   
<form method="post" action="/admin/category/select" id="selectEvent">
    {{ csrf_field() }}
    <input type="hidden" name="judge" id="judge"/>
    <table class="tablelist">
    	<thead>
            <tr>
                <th><input type="checkbox" id="select_all" /></th>
                <th>编号<i class="sort"><img src="/images/px.gif" /></i></th>
                <th>订单号</th>
                <th>订单号</th>
                <th>订单名称</th>
                <th>退款金额</th>
                <th>订单状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($list_refund as $row)
            <tr>
                <td><input name="check[]" value="{{$row['refund_id']}}" type="checkbox"/></td>
                <td>{{$row['refund_id']}}</td>
                @if ($is_admin)
                    <td>{{$row['order_id']}}</td>
                @endif
                <td>{{$row['order_number']}}</td>
                <td>{{$row['order_title']}}</td>
                <td>{{$row['refund_amount']}}</td>
                <td>{{$status::refundStatus($row['refund_status'])}}</td>
                <td>{{$row['created_at']}}</td>
                <td>
                    <a href="/admin/refund/view/{{$row['refund_id']}}" class="tablelink">查看</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</form>
        <div class="pagin">
            <div class="message">共<i class="blue">{{$count}}</i>条记录，当前显示第<i class="blue">{{$page}}</i>页</div>
            <ul class="paginList">
                <li class="paginItem"><a href="{{($page-1) < 1 ? 1 : ($page-1)}}">上一页</a></li>
                @for ($i=1;$i<=$max_page;$i++)
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

        {{--弹出删除确认框--}}
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
 
    
    </div>
    
<script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>

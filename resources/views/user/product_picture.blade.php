<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="en">
<meta charset="UTF-8">
<meta name="_token" content="{{ csrf_token() }}"/>
<title>蘑菇云-两岸特产网-添加图片</title>
<script src="/js/jquery.min.js"></script>
<link rel="stylesheet" href="/manager/css/bootstrap.min.css">
<link rel="stylesheet" href="/manager/css/base.css">
<link rel="stylesheet" href="/manager/css/main.css">
<link type="text/css" rel="stylesheet" href="/manager/css/fabugongying.css" />
<link type="text/css" rel="stylesheet" href="/manager/css/user_center.css" />
<style>
.uptop ul li{
	margin-bottom:1em;
}
.uptop ul li a{
	float: left;
    color: #00F;
    margin-left: 0.5em;
    line-height: 21px;
    margin-top: 82px;
    font-size: 13px;
}
.uptop ul li p{
	width:100%;
	float:left;
}
.uptop ul li p img{
	width:100px;
	float:left;
	text-align:center;
	margin-left: 29px;
    margin-bottom: 11px;
}
#add_attr_picture{
	width:150px; 
	float:left;
	background:#fff;
	border:1px solid #ccc;
	color:#333;
	padding:0.5em 0 0.5em;
	text-align:center;
	cursor:pointer;
}
</style>
<script>
$(document).ready(function(){
	i = 2;
	$('#add_attr_picture').click(function() {
        var tpl = '<li id="id'+i+'">\
						 <p><img src="/manager/imgs/img.png"/><a onclick="shanchu('+i+')">[删除]</a></p>\
						 <input type="text" name="picture_show[]" id="picture_show'+i+'" style="float:left;"  placeholder="输入图片地址('+i+')" /><input type="file" name="picture[]" onChange="upload('+i+')"/>\
					   </li>';
        $('#picture_li').append(tpl);
		i++;
    }); 
})	
function shanchu(id){  //删除元素
	picture_filename = $("#picture_show"+id).val();
	$.ajax({ 
		type: "post", 
		url: "/user/product_picture_delete", 
		headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
		data:{picture_filename:picture_filename},
		success: function (data) { 
					//
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
		  alert(errorThrown); 
		}
	})
	$("#id"+id).remove();
}
</script>
<script>
	function upload(id){
		$('#field_id').val(id);
		var formData = new FormData($('form')[0]);
		$.ajax({
			url: '/user/product_ajax',  //server script to process data
			type: 'POST',
			// Form数据
			data: formData,
			//Ajax事件
			dataType: "json",
			success:function (data) {
				$('#picture_show'+id).val(data.lujing);
				$('#id'+id).find('img').attr('src',data.lujing);
			},
			error:function (XMLHttpRequest, textStatus, errorThrown) { 
				alert('shibai');
			},
			//Options to tell JQuery not to process data or worry about content-type
			cache: false,
			contentType: false,
			processData: false
		});
	}
</script>
</head>
  <body>
<div class="rscla">
    <div class="rsup">
        <div class="uptop">
            <div class="upt">最多可选择同一款产品的12个图片<span>温馨提示：每张图片最大不能超过1M; </span></div>
            <div id="add_attr_picture">添加图片</div>
                <ul>
                    <form method="post" action="/user/product_ajax" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" id="field_id" name="field_id" value=""/>
                          <div id="picture_li">
                               <li id="id0">
                                 <p><img src="/manager/imgs/img.png"/><a onclick="shanchu(0)" >[删除]</a></p>
                                 <input type="text" name="picture_show[]" id="picture_show0" style="float:left;"  placeholder="输入图片地址(0)"/><input type="file" name="picture[]"  onChange="upload(0)"/>
                               </li>
                               <li id="id1">
                                 <p><img src="/manager/imgs/img.png"/><a onclick="shanchu(1)">[删除]</a></p>
                                 <input type="text" name="picture_show[]"  id="picture_show1" style="float:left;"  placeholder="输入图片地址(1)"/><input type="file" name="picture[]" onChange="upload(1)"/>
                               </li>
                           </div>
                     </form>
                </ul>
        </div> 
    </div>
</div>
  </body>
</html>
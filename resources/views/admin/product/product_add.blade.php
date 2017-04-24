<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Houtai/style.css" rel="stylesheet" type="text/css" />
<link href="/Houtai/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Houtai/jquery.js"></script>
<script type="text/javascript" src="/Houtai/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/Houtai/select-ui.min.js"></script>
<script type="text/javascript" charset="gbk" src="/Houtai/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="/Houtai/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="gbk" src="/Houtai/ueditor/lang/zh-cn/zh-cn.js"></script>


<script type="text/javascript">
    KE.show({
        id : 'content7',
        cssPath : '/css/index.css'
    });
  </script>
  
<script type="text/javascript">
$(document).ready(function(e) {
   setTimeout("Push()",200); //需要函数触发
    $(".select1").uedSelect({
		width : 345			  
	});
	$(".select2").uedSelect({
		width : 167  
	});
	$(".select3").uedSelect({
		width : 100
	});	
});
function Push() {
		$.ajax({ 
		type: "post", 
		url: "/admin/index/upload_json", 
		dataType: "json",
		success: function (data) { 
		   shuchu = data;
		   $("#xinxi_picture").val(shuchu);
		}, 
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			  setTimeout("Push()",2000);
		}
		});
}	
</script>
<meta name="__hash__" content="ae41700ea4c4b69a8b87ee72425d5578_7bf72cf8c97cee9e99fe97970f4f0bae" /></head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">信息发布</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
        <ul>
        	<li><a href="/admin/list/xinxi_view?id=1" class="selected">linux日志</a></li><li><a href="/admin/list/xinxi_view?id=5" class="selected">PHP记事本</a></li><li><a href="/admin/list/xinxi_view?id=6" class="selected">Jquery记事本</a></li><li><a href="/admin/list/xinxi_view?id=7" class="selected">Mysql记事本</a></li>        </ul>
    </div> 
    
  	<div id="tab1" class="tabson">
    
<div class="formtext">
      <p>当前栏目：</p>
      <ul>
        <li style="background:#f5f5f5;"><a href="">linux日志</a></li>
      </ul>
</div>


<form method="post" action="/admin/list/xinxi_fabu">    
    <ul class="forminfo"> 
<!--招聘页面--><div id="xinxi_zhaoping" class="xinxi_zhaoping">    
<input type="text" name="panduantypeid" value="xinxi_linux"  style="width:0; height:0; border: none;"/>
    <li><label>主题<b>*</b></label><input name="xinxi_title" type="text" class="dfinput" placeholder="请输入主题" style="width:518px;"/></li>
<li><label>封面图片<b>*</b></label><input type="text"  class="dfinput" name="xinxi_picture" id="xinxi_picture" style="float:left;"/><iframe src="/admin/index/upload" scrolling="no" frameborder="0" height="34px;" width="17%;" /></iframe></li>  
  
  
<li><label>摘要<b>*</b></label><textarea name="xinxi_zhaiyao" style="width:345px; height:150px; padding:5px;">将显示在文章标题底下</textarea></li>  
    <li><label><p class="xinxifabu_xiangxi">详细内容<b>*</b></p></label>
    
    <script id="editor" type="text/plain" style="width:1024px;height:500px; float:left;" name="xinxi_body"></script>
    <script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');


    function isFocus(e){
        alert(UE.getEditor('editor').isFocus());
        UE.dom.domUtils.preventDefault(e)
    }
    function setblur(e){
        UE.getEditor('editor').blur();
        UE.dom.domUtils.preventDefault(e)
    }
    function insertHtml() {
        var value = prompt('插入html代码', '');
        UE.getEditor('editor').execCommand('insertHtml', value)
    }
    function createEditor() {
        enableBtn();
        UE.getEditor('editor');
    }
    function getAllHtml() {
        alert(UE.getEditor('editor').getAllHtml())
    }
    function getContent() {
        var arr = [];
        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getContent());
        alert(arr.join("\n"));
    }
    function getPlainTxt() {
        var arr = [];
        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getPlainTxt());
        alert(arr.join('\n'))
    }
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        alert(arr.join("\n"));
    }
    function setDisabled() {
        UE.getEditor('editor').setDisabled('fullscreen');
        disableBtn("enable");
    }

    function setEnabled() {
        UE.getEditor('editor').setEnabled();
        enableBtn();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UE.getEditor('editor').selection.getRange();
        range.select();
        var txt = UE.getEditor('editor').selection.getText();
        alert(txt)
    }

    function getContentTxt() {
        var arr = [];
        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
        arr.push("编辑器的纯文本内容为：");
        arr.push(UE.getEditor('editor').getContentTxt());
        alert(arr.join("\n"));
    }
    function hasContent() {
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UE.getEditor('editor').hasContents());
        alert(arr.join("\n"));
    }
    function setFocus() {
        UE.getEditor('editor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UE.getEditor('editor').destroy();
    }
    function disableBtn(str) {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            if (btn.id == str) {
                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
            } else {
                btn.setAttribute("disabled", "true");
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
        }
    }

    function getLocalData () {
        alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
    }

    function clearLocalData () {
        UE.getEditor('editor').execCommand( "clearlocaldata" );
        alert("已清空草稿箱")
    }
</script>

    </li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="马上发布"/></li>
    </div>
    </ul>
<input type="hidden" name="__hash__" value="ae41700ea4c4b69a8b87ee72425d5578_7bf72cf8c97cee9e99fe97970f4f0bae" /></form>

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
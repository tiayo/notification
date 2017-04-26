<!DOCTYPE html Public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <link href="/select.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.css" rel="stylesheet">
    <script type="text/javascript" src="/jquery.js"></script>
    <script type="text/javascript" src="/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="/select-ui.min.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.js"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="gbk" src="/ueditor/lang/zh-cn/zh-cn.js"></script>


    <script type="text/javascript">
        KE.show({
            id : 'content7',
            cssPath : '/css/index.css'
        });
    </script>

    <script>
        window.onload = function () {
            flatpickr("#range", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>

</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">添加任务</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                @foreach ($all_category as $value)
                    @if ($value['parent_id'] == 0)
                        @continue
                    @endif
                <li><a href="/admin/task/add/{{$value['id']}}" class="selected">{{$value['name']}}</a></li>
                @endforeach
            </ul>
        </div>

        <!--闹钟页面-->
        <div id="tab1" class="tabson">

            <div class="formtext">
                <p>当前栏目：</p>
                <ul>
                    <li style="background:#f5f5f5;"><a href="#">{{$current['name']}}</a></li>
                </ul>
            </div>

            {{--输出错误信息--}}
            @if (count($errors) > 0)
                <div class="category_error">
                    <p>有错误，请修改：</p>
                    <ul class="umlist">
                        @foreach ($errors->all() as $error)
                            <li><a>{{ $error }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="/admin/task/add/{{$current['id']}}">
                {{ csrf_field() }}
                <ul class="forminfo">
                    <div id="xinxi_zhaoping" class="xinxi_zhaoping">
                        <li><label>标题<b>*</b></label><input name="title" type="text" class="dfinput" value="{{$old_input['title']}}" placeholder="请输入主题" style="width:518px;"/></li>
                        <input type="hidden" name="order" value="date">
                        <li><label>时间<b>*</b></label><input name="datetime" id="range" type="text" class="dfinput" value="{{$old_input['datetime']}}" placeholder="Select Date.."/></li>
                        <li><label>手机<b>*</b></label><input name="phone" type="text" class="dfinput" value="{{$old_input['phone']}}" placeholder="填写即提醒" style="width:518px;"/></li>
                        <li><label>邮箱<b>*</b></label><input name="email" type="text" class="dfinput" value="{{$old_input['email']}}" placeholder="填写即提醒" style="width:518px;"/></li>
                        <li><label><p class="content">提醒内容<b>*</b></p></label>

                            <script id="editor" type="text/plain" style="width:1024px;height:500px; float:left;" name="content">
                                {!! isset($old_input['content']) ? $old_input['content'] : '' !!}
                            </script>
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
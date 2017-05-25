@extends('layouts.app')

@section('title', '我的任务')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
    <link href="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.css" rel="stylesheet">
    {{--编辑器--}}
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
@endsection

@section('breadcrumbs')
    <li><i class="fa fa-home" aria-hidden="true"></i><a href="/">控制台</a></li>
    <li><a href="/admin/task/page/">添加任务</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>添加任务</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{$uri}}" method="post">
                                {{ csrf_field() }}
                                <div class="message-container alert alert-danger">
                                    <ul>
                                        {{--输出错误信息--}}
                                        @if (count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <label class="error">{{ $error }}</label>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="title" class=" control-label">标题<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$old_input['title']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="start_time" class=" control-label">时间<span class="required">*</span></label>
                                    <input type="hidden" name="order" value="date">
                                    <input type="text" class="form-control" id="start_time" name="start_time"  value="{{$old_input['start_time']}}" placeholder="Select Time.." required>
                                </div>
                                <div class="form-group">
                                        <label for="plan" class="control-label">计划<span class="required">*</span></label>
                                        <select name="plan" id="plan" class="form-control select2-hidden-accessible" required>
                                            @if (!empty($old_input['plan']))
                                                <option value="{{$old_input['plan']}}">{{$plan::plan($old_input['plan'])}}</option>
                                            @endif
                                            <option value="1">一次</option>
                                            <option value="2">每天</option>
                                            <option value="3">工作日（周一到周五）</option>
                                            <option value="4">工作日（周一到周六）</option>
                                            <option value="5">工作日（智能跳过法定节假日）</option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class=" control-label">手机<span class="required">*</span></label>
                                    <input type="number" class="form-control" id="phone" name="phone" value="{{$old_input['phone']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class=" control-label">邮箱<span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$old_input['email']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="content" class=" control-label">提醒内容<span class="required">*</span></label>
                                    <script id="editor" type="text/plain" style="width:100%;height:500px;" name="content">
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
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/javascripts/examples/forms/validation.js"></script>
    <script>
        window.onload = function () {
            flatpickr("#start_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>
@endsection
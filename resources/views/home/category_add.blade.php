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
    <script type="text/javascript">
        $(document).ready(function(e) {
            $(".select1").uedSelect({
                width : 345
            });
        });
    </script>

        </head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">添加分类</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#" class="selected">添加分类</a></li>
            </ul>
        </div>

        <!--闹钟页面-->
        <div id="tab1" class="tabson">
             {{--输出错误信息--}}
            {{var_dump($input)}}
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

            <form method="post" action="{{route('category_add')}}">
                {{ csrf_field() }}
                <ul class="forminfo">
                    <div id="xinxi_zhaoping" class="xinxi_zhaoping">
                        <li><label>名称<b>*</b></label><input name="name" type="text" class="dfinput" placeholder="请输入分类名称" style="width:518px;"/></li>
                        <li>
                            <label>父级<b>*</b></label>
                            <div class="vocation">
                                <select class="select1" name="parent_id" style="width: 347px;">
                                    @foreach ($all_category as $value)
                                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li><label>别名<b>*</b></label><input name="alias" type="text" class="dfinput" placeholder="填写栏目别名" style="width:518px;"/></li>
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
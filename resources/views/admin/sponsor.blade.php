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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pay_submit').click(function(){
                if ($('#money_select').css('display') === 'none') {
                    $('#form2').submit();
                } else {
                    $('#form').submit();
                }
            });
        });
    </script>
    <script type="text/javascript">
        function other_money() {
            var option_money = $('.select1').val();
            if (option_money === '0') {
                $('#other_input').css('display', 'block');
                $('#money_select').css('display', 'none');
            }
        }
    </script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">赞助我们</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#" class="selected">赞助我们</a></li>
            </ul>
        </div>

        <!--闹钟页面-->
        <div id="tab1" class="tabson">

            <form id="form" method="post" action="/admin/sponsor">
                {{ csrf_field() }}
                <ul class="forminfo">
                    <div class="xinxi_zhaoping">
                        <li id="money_select">
                            <label>金额<b>*</b></label>
                            <div class="vocation">
                                <select class="select1" name="money" style="width: 347px;" onchange="other_money()">
                                    <option value="10.00">10.00</option>
                                    <option value="20.00">20.00</option>
                                    <option value="30.00">30.00</option>
                                    <option value="50.00">50.00</option>
                                    <option value="100.00">100.00</option>
                                    <option value="0">输入其他金额</option>
                                </select>
                            </div>
                        </li>
                    </div>
                </ul>
            </form>

            <form id="form2" method="post" action="/admin/sponsor">
                {{ csrf_field() }}
                <ul class="forminfo">
                    <div class="xinxi_zhaoping">
                        <li id="other_input" style="display: none;"><label>金额<b>*</b></label><input name="money" type="text" class="dfinput"/></li>
                    </div>
                </ul>
            </form>

            <p><input id="pay_submit" type="button" class="btn" value="确定"/></p>
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
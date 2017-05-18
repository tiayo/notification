<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
    <script>
        $(document).ready(function () {
            //查询订单状态
            setInterval("push()",1000);
            //刷新二维码
            $('#refresh').click(function () {
                $.ajax({
                    type: "get",
                    url: "/admin/wxpay/refresh/{{$order['order_id']}}",
                    dataType: "json",
                    success: function (data) {
                        $('#weixin_pay_code').attr('src', 'http://paysdk.weixin.qq.com/example/qrcode.php?data='+data);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            })
        });

        //查询订单
        function push() {
            $.ajax({
                type: "get",
                url: "/admin/wxpay/query/{{$order['order_id']}}",
                dataType: "json",
                success: function (data) {
                    if (data == 'success') {
                        window.location.href='/admin/wxpay/callback/{{$order['order_id']}}';
                    }
                }
            });
        }
    </script>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
    <h1>{{config('site.title')}}收银台-微信付款</h1>
</header>
<div id="main">
    <form id='pay_form' method=post target="_blank">
        {{ csrf_field() }}
        <div id="body" style="clear:left">
            <dl class="content">
                <hr class="one_line">
                <dt></dt>
                <dd id="btn-dd">
                    <img id="weixin_pay_code" src="http://paysdk.weixin.qq.com/example/qrcode.php?data={{urlencode($pay_url)}}" style="width:150px;height:150px;"/>
                </dd>
                <hr class="one_line">
                <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="refresh" type="button" style="text-align:center;">刷 新</button>
                        </span>
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="button" style="text-align:center;" onclick="location.href='/admin/wxpay/callback/{{$order['order_id']}}'">已完成 付款</button>
                        </span>
                    <span class="note-help">如果显示订单过期，请按‘刷新’按钮重新生成。</span>
                </dd>
            </dl>
        </div>
    </form>

    <div id="foot">
        <ul class="foot-ul">
            <li>
                {{config('site.title')}}版权所有 2015-2018 TIAYO.COM
            </li>
        </ul>
    </div>
</div>
</body>
</html>
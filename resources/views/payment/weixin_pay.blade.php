<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
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
                    <img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data={{urlencode($pay_url)}}" style="width:150px;height:150px;"/>
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
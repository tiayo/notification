<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/pay_confirm.css">
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                {{$info['jsApiParameters']}},
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    alert(res.err_code+res.err_desc+res.err_msg);
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">
        //获取共享地址
        function editAddress()
        {
            WeixinJSBridge.invoke(
                'editAddress',
                {{$info['editAddress']}},
                function(res){
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;

                    alert(value1 + value2 + value3 + value4 + ":" + tel);
                }
            );
        }

        window.onload = function(){
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', editAddress);
                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
                }
            }else{
                editAddress();
            }
        };

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
<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#alipay').click(function () {
                $('#pay_form').attr('action', '/admin/alipay/pay');
                $('#pay_form').submit();
           });
           
           $('#weixin').click(function () {
               $('#pay_form').attr('action', '/admin/weixin/pay');
               $('#pay_form').submit();
           });
        });
    </script>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
    <h1>{{config('site.title')}}收银台</h1>
</header>
<div id="main">
    <form id='pay_form' method=post target="_blank">
        {{ csrf_field() }}
        <div id="body" style="clear:left">
            <dl class="content">
                <dt>商户订单号
                    ：</dt>
                <dd>
                    <input id="WIDout_trade_no" name="WIDout_trade_no" value="{{$order['order_number']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>订单名称
                    ：</dt>
                <dd>
                    <input id="WIDsubject" name="WIDsubject" value="{{$order['title']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>付款金额
                    ：</dt>
                <dd>
                    <input id="WIDtotal_amount" name="WIDtotal_amount" value="{{$order['total_amount']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>商品描述：</dt>
                <dd>
                    <input id="WIDbody" name="WIDbody" value="{{$order['content']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>订单状态：</dt>
                <dd>
                    <input value="{{$judge::orderStatus($order['order_status'])}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>付款类型：</dt>
                <dd>
                    <input value="{{$judge::paymentType($order['payment_type'])}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>付款状态：</dt>
                <dd>
                    <input value="{{$judge::paymentStatus($order['payment_status'])}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>交易号：</dt>
                <dd>
                    <input value="{{$order['trade_no'] or '未获取'}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>下单用户：</dt>
                <dd>
                    <input value="{{$order['name']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>创建时间：</dt>
                <dd>
                    <input value="{{$order['created_at']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>更新时间：</dt>
                <dd>
                    <input value="{{$order['updated_at']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt></dt>
                <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="alipay" type="button">支付宝 支付</button>
                        </span>

                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="weixin"  type="button">微信 支付</button>
                        </span>

                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="button" onclick="location.href='/admin/alipay/refund/{{$order['order_id']}}'">退 款(申请)</button>
                        </span>

                    <span class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。</span>
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
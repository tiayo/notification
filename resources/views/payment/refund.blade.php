<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $('#sub')
        })
    </script>

</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
        <h1>{{config('site.title')}}-退款</h1>
</header>
<div id="main">
        <form name=alipayment action='/admin/alipay/refund/{{$order['order_id']}}' method=post>
            {{ csrf_field() }}
            <div id="body" style="clear:left">
                <dl class="content">
                    <dt></dt>
                    <dd>
                        {{--输出错误信息--}}
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <span style="line-height: 28px; color:red;">注意：{{ $error }}</span>
                            @endforeach
                        @endif
                    </dd>

                    <hr class="one_line">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="out_trade_no" name="out_trade_no" value="{{$order['order_number']}}" readonly/>
                    </dd>
                    <hr class="one_line">
                    <dt>支付宝交易号：</dt>
                    <dd>
                        <input id="trade_no" name="trade_no" value="{{$order['trade_no']}}" readonly/>
                    </dd>
                    <hr class="one_line">
                    <dt>退款金额：</dt>
                    <dd>
                        <input id="refund_amount" name="refund_amount" placeholder="最多可以退{{$order['total_amount']}}元。"/>
                    </dd>
                    <hr class="one_line">
                    <dt>退款原因：</dt>
                    <dd>
                        <input id="refund_reason" name="refund_reason" />
                    </dd>
                    <hr class="one_line">
                    <dt>退款单号：</dt>
                    <dd>
                        <input id="out_request_no" name="out_request_no" value="{{$refund_number}}" readonly />
                    </dd>
                    <hr class="one_line">
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="submit" type="button" style="text-align:center;">提交 退款 申请</button>
                        </span>
                        <span class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。</span>
                    </dd>
                </dl>
            </div>
        </form>
        <div id="foot">
            <ul class="foot-ul">
                <li>
                    {{config('site.title')}}版权所有 2011-{{date("Y")}} TIAYO.COM
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
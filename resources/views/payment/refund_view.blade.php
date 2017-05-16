<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#agree').click(function () {
                $('#confirm_form').attr('action', '/admin/refund/confirm/agree/');
                $('#confirm_form').submit();
           });
           
           $('#refuse').click(function () {
               $('#confirm_form').attr('action', '/admin/refund/confirm/refuse');
               $('#confirm_form').submit();
           });
        });
    </script>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
    <h1>{{config('site.title')}}收银台</h1>
</header>
<div id="main">
    <form id='confirm_form' method=get>
        {{ csrf_field() }}
        <input type="hidden" name="refund_id" value="{{$refund['refund_id']}}">
        <div id="body" style="clear:left">
            <dl class="content">
                <dt>退款编号
                    ：</dt>
                <dd>
                    <input value="{{$refund['refund_number']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>订单名称
                    ：</dt>
                <dd>
                    <input value="{{$refund['order_title']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>退款金额
                    ：</dt>
                <dd>
                    <input value="{{$refund['refund_amount']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>退款原因：</dt>
                <dd>
                    <input value="{{$refund['refund_reason']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>退款状态：</dt>
                <dd>
                    <input value="{{$judge::refundStatus($refund['refund_status'])}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>付款类型：</dt>
                <dd>
                    <input value="{{$judge::paymentType($refund['payment_type'])}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>交易号：</dt>
                <dd>
                    <input value="{{$refund['trade_no'] or '未获取'}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>订单号：</dt>
                <dd>
                    <input value="{{$refund['order_number'] or '未获取'}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>用户：</dt>
                <dd>
                    <input value="{{$refund['name']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>创建时间：</dt>
                <dd>
                    <input value="{{$refund['created_at']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>更新时间：</dt>
                <dd>
                    <input value="{{$refund['updated_at']}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt></dt>
                <dd id="btn-dd">
                     <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="refuse"  type="button">拒绝 退款</button>
                     </span>

                    <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="agree" type="button">同意 退款</button>
                    </span>

                    <span class="new-btn-login-sp">
                        <button class="new-btn-login" type="button" onclick="location.href='/admin/refund/page/1'">返回</button>
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
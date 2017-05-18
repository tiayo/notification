<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link type="text/css" rel="stylesheet" href="/payment.css"/>
    <title>付款成功--随享校园社区收银台</title>
</head>
<body>

<div class="page">
    <div class="page-container">
        <div class="page-main">
            <h3>
                <strong>付款成功！</strong>订单号：{{$order['order_number']}}
            </h3>
            <div class="page-actions">
                <div class="detail">
                    <ol>
                   		<h4>订单信息：</h4>
                        <li>订单名称：{{$order['title']}}</li>
                        <li>订单内容：{{$order['content']}}</li>
                        <li>订单价格：{{$order['total_amount']}}</li>
                        <li>支付状态:{{$status::paymentType($order['payment_type']).'('.$status::paymentStatus($order['payment_status']).')'}}</li>
                    </ol>
                </div>
                <div class="option">
                    <ul>
                    <h4>您可以：</h4>
                        <li><a href="javascript:window.opener=null;window.open('','_self');window.close();">关闭页面</a></li>
                        <li><a href="/">返回首页</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link type="text/css" rel="stylesheet" href="/payment.css"/>
    <title>未成功付款--随享校园社区收银台</title>
</head>
<body>

<div class="page">
    <div class="page-container">
        <div class="page-main">
            <h3>
                <strong>付款失败！</strong>订单号：{{$order['order_number']}}
            </h3>
            <div class="page-actions">
                <div class="detail">
                    <ol>
                        <h4>订单信息：</h4>
                        <li>订单名称：{{$order['title']}}</li>
                        <li>订单内容：{{$order['content']}}</li>
                        <li>订单价格：{{$order['total_amount']}}</li>
                        <li>支付状态:{{$status::paymentType($order['payment_type']).'('.$status::paymentStatus($order['payment_status']).')'}}</li>
                        <li style="color: red">如果已经付款：同步最长时间为2小时，请稍后到管理后台订单管理查看；</li>
                    </ol>
                </div>
                <div class="option">
                    <ul>
                        <h4>您可以：</h4>
                        <li><a href="#" onclick="location.href = history.go(-1)">重新付款</a></li>
                        <li><a href="/">返回首页</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
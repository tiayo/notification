<?php

namespace App\Services;

interface PayInterfaces
{
    //判断是否管理员权限
    public function isAdmin();

    //判断当前用户操作订单权限
    public function verfication($order_id);

    //跳转到网关支付
    public function pay($post, $order);

    //电脑版本支付
    public function pagePay($array, $order);

    //手机版本支付
    public function wapPay($array, $order);

    //查询订单
    public function query($order_id);

    //处理退款
    public function refund($refund, $request);

    //接收回调并处理
    public function callback($value);

    //接收处理异步通知
    public function app($app);
}
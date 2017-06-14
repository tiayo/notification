<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use App\Service\PaymentCheckService;
use App\Service\WxpayService;
use Illuminate\Http\Request;

class WxpayController extends Controller
{
    protected $request;
    protected $order;
    protected $refund;
    protected $wxpay;
    protected $payment;

    public function __construct(Request $request,
                                OrderRepositories $order,
                                RefundRepositories $refund,
                                WxpayService $wxpay,
                                PaymentCheckService $payment)
    {
        $this->request = $request;
        $this->order = $order;
        $this->refund = $refund;
        $this->wxpay = $wxpay;
        $this->payment = $payment;
    }

    /**
     * 跳转到微信付款
     * 过滤已经付款的订单
     *
     */
    public function pay($order_id = null)
    {
        $post = $this->request->all();
        if (empty($order_id)) {
            $order = $this->order->findOne('order_number', $post['WIDout_trade_no']);
        } else {
            $order = $this->order->findOne('order_id', $order_id);
        }

        $array = $this->wxpay->Pay($post, $order);

        //电脑扫码支付页面
        if ($array['type'] = 'pagePay') {
            return view('payment.wxpay_pagepay', [
                'pay_url' => $array['data'],
                'order' => $order,
            ]);
        }

        //手机JSAPI支付
        if ($array['type'] = 'wapPay') {
            return view('payment.wxpay_wappay', [
                'info' => $array['data'],
                'order' => $order,
            ]);
        }

    }

    /**
     * 接收微信异步数据
     * XML数据
     *
     */
    public function app()
    {
        $input = file_get_contents('php://input');
        return response($this->wxpay->app($input));
    }

    /**
     * 查询订单
     * 权限验证
     *
     * @param $order_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function query($order_id)
    {
        // 权限验证
        try {
            $this->wxpay->verfication($order_id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        //获取支付结果
        $order = $this->order->findOne('order_id', $order_id);
        if ($this->payment->wxpay($order_id, $order)) {
            //成功
            return response()->json('success');
        }

        //失败
        return response()->json('faile');
    }

    /**
     * 返回支付结果
     * 权限验证
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function callback($order_id)
    {
        try {
            $this->wxpay->callback($order_id);
        } catch (\Exception $e) {
            //支付失败页面
            return view('payment.faile', [
                'order' => $this->order->findOne('order_id', $order_id),
                'status' => app('App\Http\Controllers\Controller'),
            ]);
        }

        //支付成功页面
        return view('payment.success', [
            'order' => $this->order->findOne('order_id', $order_id),
            'status' => app('App\Http\Controllers\Controller'),
        ]);
    }

    /**
     * 刷新订单（重新生成订单号后再重新获取二维码URL）
     * 返回json格式数据
     *
     * @param $order_id
     * @return string
     */
    public function refresh($order_id)
    {
        try {
            $url = $this->wxpay->refresh($order_id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json(urlencode($url));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use App\Service\PaymentCheckService;
use App\Service\WeixinService;
use Illuminate\Http\Request;

class WeixinController extends Controller
{
    protected $request;
    protected $order;
    protected $refund;
    protected $weixin;
    protected $payment;

    public function __construct(Request $request,
                                OrderRepositories $order,
                                RefundRepositories $refund,
                                WeixinService $weixin,
                                PaymentCheckService $payment
    )
    {
        $this->request = $request;
        $this->order = $order;
        $this->refund = $refund;
        $this->weixin = $weixin;
        $this->payment = $payment;
    }

    /**
     * 跳转到微信付款
     * 过滤已经付款的订单
     *
     */
    public function pay()
    {
        $post = $this->request->all();
        $order = $this->order->findOne('order_number', $post['WIDout_trade_no']);
        try {
            $pay_url = $this->weixin->Pay($post, $order);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return view('payment.weixin_pay', [
            'pay_url' => $pay_url,
            'order' => $order,
        ]);
    }

    /**
     * 接收微信异步数据
     * XML数据
     *
     */
    public function app()
    {
        $input = file_get_contents('php://input');
        return response($this->weixin->app($input));
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
            $this->weixin->verfication($order_id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        //获取支付结果
        $order = $this->order->findOne('order_id', $order_id);
        if ($this->payment->weixin($order_id, $order)) {
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
            $this->weixin->callback($order_id);
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
            $url = $this->weixin->refresh($order_id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json(urlencode($url));
    }

}

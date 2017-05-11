<?php

namespace App\Service;

use App\Alipay\Wappay\Service\AlipayTradeService;
use App\Alipay\Wappay\Buildermodel\AlipayTradeWapPayContentBuilder;
use App\Alipay\Wappay\Buildermodel\AlipayTradeQueryContentBuilder;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class AlipayService
{
    protected $order;

    public function __construct(OrderRepositories $order)
    {
        $this->order = $order;
    }

    /**
     * 支付
     *
     * @param $post
     */
    public function pay($post)
    {
        if (!empty($post['WIDout_trade_no'])&& trim($post['WIDout_trade_no'])!=""){
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $post['WIDout_trade_no'];

            //订单名称，必填
            $subject = $post['WIDsubject'];

            //付款金额，必填
            $total_amount = $post['WIDtotal_amount'];

            //商品描述，可空
            $body = $post['WIDbody'];

            //超时时间
            $timeout_express="1m";

            $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);

            $alipayTradeService = new AlipayTradeService();
            $alipayTradeService->wapPay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));
        }
    }

    /**
     * 查询交易状态
     *
     * @param $post
     * @return bool
     */
    public function query($order_id)
    {
        $result = [];

        //从数据库获取订单数据
        $order_detail = $this->order->findOne($order_id);

        if (!empty($order_detail['order_id']) || !empty($order_detail['trade_no'])){

            //商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
            //商户订单号，和支付宝交易号二选一
            $out_trade_no = trim($order_detail['order_id']);

            //支付宝交易号，和商户订单号二选一
            $trade_no = trim($order_detail['trade_no']);

            $RequestBuilder = new AlipayTradeQueryContentBuilder();
            $RequestBuilder->setTradeNo($trade_no);
            $RequestBuilder->setOutTradeNo($out_trade_no);

            $Response = new AlipayTradeService();
            $result = $Response->Query($RequestBuilder);
        }

        //验证返回的订单交易号
        if ($result->trade_no == $order_detail['trade_no'])
        {
            //获取交易结果
            if ($result->trade_status == 'TRADE_SUCCESS' || $result->trade_status == 'TRADE_FINISHED') {
                //修改订单付款状态和付款方式
                $this->order->update('order_id', $order_id, [
                    'payment_status' => 1,
                ]);
                return true;
            }
            return false;
        }
        throw new Exception('返回的订单验证不通过，请联系管理员。', 401);
    }


    /**
     * 本地验证+查询验证
     * 找不到订单抛404
     * 验证失败抛403\401
     *
     * @param $get
     */
    public function callback($get)
    {
        $order_id = $get['out_trade_no'];
        $order_detail = $this->order->findOne($order_id);

        //如果已经接收到异步请求并验证通过，则直接跳过回调查询
        if ($order_detail['payment_status'] == 1) {
            return true;
        }
        Log::info('jinru');
        
        //查询订单详情
        if (empty($order_detail)) {
            throw new Exception('找不到订单', 404);
        }

        //本地验证订单合法性
        if ($get['total_amount'] == $order_detail['total_amount'] &&
            $get['seller_id'] == config('alipay.seller_id') &&
            $get['app_id'] == config('alipay.app_id')
        ) {
            //记录交易号
            $this->order->update('order_id', $order_id, [
                'payment_type' => 'alipay',
                'trade_no' => $get['trade_no'],
            ]);

            //查询交易状态
            if ($this->query($order_id)) {
                return true;
            }
        }

        throw new Exception('订单本地验证不通过，请联系管理员。', 403);
    }

}
<?php

namespace App\Service;

use App\Payment\Alipay\Pay\Service\AlipayTradeService;
use App\Payment\Alipay\Pay\Buildermodel\AlipayTradeQueryContentBuilder;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use BrowserDetect;

class AlipayService
{
    protected $order;

    public function __construct(OrderRepositories $order)
    {
        $this->order = $order;
    }

    public function Pay($post)
    {
        if (!empty($post['WIDout_trade_no'])&& trim($post['WIDout_trade_no'])!="") {
            $array['out_trade_no'] = $post['WIDout_trade_no'];
            $array['total_amount'] = $post['WIDtotal_amount'];
            $array['subject'] = $post['WIDsubject'];
            $array['body'] = $post['WIDbody'];
        }

        //判断电脑端或手机端，调用对应方法
        if (BrowserDetect::isMobile() || BrowserDetect::isTablet()) {
            $payRequestBuilder = $this->wapPay($array);
        } elseif (BrowserDetect::isDesktop()) {
            $payRequestBuilder = $this->pagePay($array);
        }

        $alipayTradeService = new AlipayTradeService();
        $alipayTradeService->pagePay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));
    }

    /**
     * 电脑端支付
     *
     * @param $post
     */
    public function pagePay($array)
    {
        $array['product_code'] = 'FAST_INSTANT_TRADE_PAY';
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 手机端支付
     *
     * @param $post
     */
    public function wapPay($array)
    {
        $array['product_code'] = 'QUICK_WAP_PAY';
        return json_encode($array, JSON_UNESCAPED_UNICODE);
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
        $order_detail = $this->order->findOne('order_id', $order_id);

        //判断订单是否存在
        if (empty($order_detail)) {
            throw new \Exception('订单不存在！', 403);
        }

        //判断交易码是否存在
        if (empty($order_detail['order_number']) || empty($order_detail['trade_no'])) {
            return false;
        }

        //商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
        //商户订单号，和支付宝交易号二选一
        $out_trade_no = trim($order_detail['order_number']);

        //支付宝交易号，和商户订单号二选一
        $trade_no = trim($order_detail['trade_no']);

        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);

        $Response = new AlipayTradeService();
        $result = $Response->Query($RequestBuilder);


        //验证返回的订单交易号
        if ($result->trade_no == $order_detail['trade_no'] && $result->out_trade_no == $order_detail['order_number'])
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
        $order_number = $get['out_trade_no'];
        $order_detail = $this->order->findOne('order_number', $order_number);
        $order_id = $order_detail['order_id'];

        //如果已经接收到异步请求并验证通过，则直接跳过回调查询
        if ($order_detail['payment_status'] == 1) {
            //记录成功到日志
            Log::info('order_detail_success:'.json_encode($order_detail));
            return true;
        }
        //记录错误到日志
        Log::info('order_detail_faile:'.json_encode($order_detail));

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
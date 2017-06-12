<?php
/**
 * 主动检查未付款订单是否已经付款
 * 避免未收到异步通知
 */
namespace App\Service;

use App\Repositories\OrderRepositories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentCheckService
{
    protected $order;
    protected $alipay;
    protected $wxpay;

    public function __construct(OrderRepositories $order, AlipayService $alipay, WxpayService $wxpay)
    {
        $this->order = $order;
        $this->alipay = $alipay;
        $this->wxpay = $wxpay;
    }

    /**
     * 选择相应的验证方法
     */
    public function check()
    {
        $all_order = $this->order->getWhere('payment_status', 1, '<>');
        foreach ($all_order as $order) {
            if ($this->alipay($order['order_id'], $order)) {
                continue;
            }
            $this->wxpay($order['order_id'], $order);
        }

        //记录
        Log::info('run payment end:'.Carbon::now());
    }

    /**
     * 支付宝验证
     *
     * @param $order_id
     * @param $order
     * @return bool
     */
    public function alipay($order_id, $order)
    {

        //报错直接跳过
        try {
            $result = $this->alipay->query($order);
        } catch (\Exception $e) {
            return false;
        }

        //判断是否有有效数据
        if (!$result || empty($result)) {
            return false;
        }

        //判断返回的数据是否达到要求
        if (empty($result->msg) || $result->msg != 'Success') {
            return false;
        }

        //验证返回的订单交易号
        if ($result->out_trade_no == $order['order_number'] &&
            $result->total_amount == $order['total_amount']
            )
        {
            //获取交易结果
            if ($result->trade_status == 'TRADE_SUCCESS' || $result->trade_status == 'TRADE_FINISHED') {
                //修改订单付款状态和付款方式
                $this->order->update('order_id', $order_id, [
                    'payment_type' => 'alipay',
                    'trade_no' => $result->trade_no,
                    'payment_status' => 1
                ]);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 微信验证
     *
     * @param $order_id
     * @param $order
     * @return bool
     */
    public function wxpay($order_id, $order)
    {
        //报错直接跳过
        try {
            $result = $this->wxpay->query($order);
        } catch (\Exception $e) {
            return false;
        }

        //判断是否有有效数据
        if (!$result || empty($result)) {
            return false;
        }

        //判断返回的数据是否达到要求
        if ($result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS'|| $result['trade_state'] != 'SUCCESS') {
            return false;
        }

        //验证返回的订单交易号、订单号
        if ($result['out_trade_no'] == $order['order_number'] &&
            $result['total_fee'] == ($order['total_amount']*100)
        )
        {
            //获取交易结果
            if ($result['trade_state'] == 'SUCCESS') {
                //修改订单付款状态和付款方式
                $this->order->update('order_id', $order_id, [
                    'payment_type' => 'weixin',
                    'trade_no' => $result['transaction_id'],
                    'payment_status' => 1
                ]);
                return true;
            }
            return false;
        }
        return false;
    }
}
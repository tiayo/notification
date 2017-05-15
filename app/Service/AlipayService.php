<?php

namespace App\Service;

use App\Facades\Verfication;
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

    /**
     * 权限验证
     *
     * @return bool
     */
    public function isAdmin()
    {
        try {
            Verfication::admin(AlipayService::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
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
            $this->wapPay($array);
        } elseif (BrowserDetect::isDesktop()) {
            $this->pagePay($array);
        }
    }

    /**
     * 电脑端支付
     *
     * @param $post
     */
    public function pagePay($array)
    {
        $array['product_code'] = 'FAST_INSTANT_TRADE_PAY';
        $payRequestBuilder = json_encode($array, JSON_UNESCAPED_UNICODE);

        $alipayTradeService = new AlipayTradeService();
        $alipayTradeService->pagePay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));
    }

    /**
     * 手机端支付
     *
     * @param $post
     */
    public function wapPay($array)
    {
        $array['product_code'] = 'QUICK_WAP_PAY';
        $payRequestBuilder = json_encode($array, JSON_UNESCAPED_UNICODE);

        $alipayTradeService = new AlipayTradeService();
        $alipayTradeService->wapPay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));
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
     * 退款视图
     *
     * @param $order_id
     * @return mixed
     * @throws \Exception
     */
    public function refundView($order_id)
    {
        $order = $this->order->findOne('order_id', $order_id);
        if ($order['payment_status'] != 1) {
            throw new \Exception('当前订单付款状态不允许退款，请稍候再试。');
        }
        return $order;
    }

    /**
     * 发起退款
     *
     * @param $data
     */
    public function refundAction($data, $order_id)
    {
        $order = $this->order->findOne('order_id', $order_id);

        //验证订单正确性
        if ($data['out_trade_no'] == $order['order_number'] &&
            $data['trade_no'] == $order['trade_no']
        ) {
            //验证退款金额

        }

        throw new \Exception('订单信息有误！');
    }

    /**
     * 提交退款
     *
     * @param $data
     */
    public function refund($data)
    {
        if (!empty($_POST['WIDout_trade_no']) || !empty($_POST['WIDtrade_no'])) {

            //商户订单号，和支付宝交易号二选一
            $out_trade_no = trim($_POST['WIDout_trade_no']);

            //支付宝交易号，和商户订单号二选一
            $trade_no = trim($_POST['WIDtrade_no']);

            //退款金额，不能大于订单总金额
            $refund_amount=trim($_POST['WIDrefund_amount']);

            //退款的原因说明
            $refund_reason=trim($_POST['WIDrefund_reason']);

            //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
            $out_request_no=trim($_POST['WIDout_request_no']);

            $RequestBuilder = new AlipayTradeRefundContentBuilder();
            $RequestBuilder->setTradeNo($trade_no);
            $RequestBuilder->setOutTradeNo($out_trade_no);
            $RequestBuilder->setRefundAmount($refund_amount);
            $RequestBuilder->setRefundReason($refund_reason);
            $RequestBuilder->setOutRequestNo($out_request_no);

            $Response = new AlipayTradeService($config);
            $result=$Response->Refund($RequestBuilder);
            return ;
        }
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
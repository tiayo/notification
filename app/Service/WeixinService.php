<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Payment\Alipay\Pay\Service\AlipayTradeService;
use App\Payment\Alipay\Pay\Buildermodel\AlipayTradeQueryContentBuilder;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use BrowserDetect;
use App\Payment\Weixin\Pay\CLogFileHandler;
use App\Payment\Weixin\Pay\LogWeixin;
use App\Payment\Weixin\Lib\WxPayRefund;
use App\Payment\Weixin\Lib\WxPayApi;
use App\Payment\Weixin\Lib\WxPayUnifiedOrder;
use App\Payment\Weixin\Lib\NativePay;

class WeixinService
{
    protected $order;
    protected $refund;

    public function __construct(OrderRepositories $order, RefundRepositories $refund)
    {
        $this->order = $order;
        $this->refund = $refund;
    }

    public function Pay($post)
    {
        //判断电脑端或手机端，调用对应方法
        if (BrowserDetect::isMobile() || BrowserDetect::isTablet()) {
            $this->wapPay($post);
        } elseif (BrowserDetect::isDesktop()) {
            $this->pagePay($post);
        }
    }

    /**
     * 电脑端支付
     *
     * @param $post
     */
    public function pagePay($array)
    {
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($array['WIDbody']);
        $input->SetAttach(config('site.title'));
        $input->SetOut_trade_no($array['WIDout_trade_no']);
        $input->SetTotal_fee($array['WIDtotal_amount']*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        //$input->SetGoods_tag("test");//商品标记，使用代金券或立减优惠功能时需要的参数，说明详见代金券或立减优惠
        $input->SetNotify_url(config('weixin.NOTIFY_URL'));
        dd(config('weixin.NOTIFY_URL'));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("WIDout_trade_no");
        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"] ?? null;

        //判断订单是否已经生成过支付链接
        if (empty($url2)) {
            $url2 = $this->order->findOne('order_number', $array['WIDout_trade_no'])['trade_no'];
        }

        //记录二维码地址
        $this->order->update('order_number', $array['WIDout_trade_no'], ['trade_no' => $url2]);

        //返回支付
        return $url2;
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
     * 提交退款
     *
     * @param $data
     * @return bool
     */
    public function refund($refund, $request)
    {
        //初始化日志
        $logHandler= new CLogFileHandler(__DIR__."/../Payment/Weixin/logs/".date('Y-m-d').'.log');
        $log = LogWeixin::Init($logHandler, 15);

        function printf_info($data)
        {
            foreach($data as $key=>$value){
                echo "<font color='#f00;'>$key</font> : $value <br/>";
            }
        }

        if(!empty($refund["order_number"])){
            $out_trade_no = $refund["order_number"];
            $total_fee = $refund["total_amount"];
            $refund_fee = $refund["refund_amount"];
            $input = new WxPayRefund();
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee);
            $input->SetRefund_fee($refund_fee);
            $input->SetOut_refund_no($refund['refund_number']);
            $input->SetOp_user_id(Auth::id());

            //获取退款结果
            $result = WxPayApi::refund($input);
        }

        //处理完毕
        if ($result['result_code'] == 'SUCCESS' && $refund['trade_no'] == $result['transaction_id']) {
            //更新退款信息
            $data['refund_status'] = 3;//状态：退款成功
            $data['reply'] = $request['reply'];
            $this->refund->update('refund_id', $request['refund_id'], $data);

            //更新订单信息
            $order_id = $this->refund->findOne('refund_id', $request['refund_id'])['order_id'];
            $value['order_status'] = 3;//状态：退款成功
            $this->order->update('order_id', $order_id, $value);

            return true;
        }

        //错误抛错
        throw new \Exception($result['return_msg'] ?? '退款出问题了！请联系管理员！');
    }


    /**
     * 权限验证
     *
     * @return bool
     */
    public function isAdmin()
    {
        try {
            Verfication::admin(WeixinService::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 验证用户是否可以操作本条订单
     * 验证失败抛错误
     *
     * @param $order_id
     * @return bool
     * @throws \Exception
     */
    public function verfication($order_id)
    {
        if (!Verfication::update($this->order->findOne('order_id', $order_id))) {
            throw new \Exception('您没有权限访问（代码：1003）！', 403);
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
     * 订单状态为1,2 + 付款状态为1 的订单才可以发起退款
     * 退款订单存在则判断退款状态（退款状态为2：申请退款 才可以修改）
     *
     * @param $order_id
     * @return mixed
     * @throws \Exception
     */
    public function refundView($order_id)
    {
        //验证状态是否可以操作
        if (!empty($refund_exist = $this->refund->findOne('order_id', $order_id))) {
            if ($refund_exist['refund_status'] != 2) {
                throw new \Exception('当前退款状态不允许修改！');
            }
        }

        //权限验证
        $this->verfication($order_id);

        $order = $this->order->findOne('order_id', $order_id);

        if ($order['order_status'] != 1 && $order['order_status'] != 2) {
            throw new \Exception('当前订单状态不允许退款，请联系管理员。');
        }

        if ($order['payment_status'] != 1) {
            throw new \Exception('当前订单付款状态不允许退款，请确定订单已经完成付款。');
        }

        return $order;
    }

    /**
     * 发起退款
     * 金额不超过订单总额，并且限制小数点为两位
     * 退款订单存在则执行更新方法（退款状态为2：申请退款 才可以修改）
     *
     * @param $data
     */
    public function refundAction($data, $order_id)
    {
        //权限验证
        $this->verfication($order_id);

        //初始化
        $value = [];

        //验证订单状态、付款状态是否符合条件
        $order = $this->refundView($order_id);

        //验证订单正确性
        if ($data['out_trade_no'] != $order['order_number'] ||
            $data['trade_no'] != $order['trade_no']
        ) {
            throw new \Exception('订单本地验证失败！');
        }

        //验证退款金额
        $refund_amount = (float)$data['refund_amount'];
        $decimal = explode('.', (string)$refund_amount)[1] ?? null;
        if (strlen($decimal) > 2 || $refund_amount > $order['total_amount'] || $refund_amount <= 0) {
            throw new \Exception('退款金额验证失败！');
        }

        //提交数组
        $value['refund_number'] = $data['refund_number'];
        $value['user_id'] = $order['user_id'];
        $value['order_id'] = $order_id;
        $value['order_number'] = $order['order_number'];
        $value['trade_no'] =  $order['trade_no'];
        $value['refund_amount'] = $data['refund_amount'];
        $value['refund_reason'] = $data['refund_reason'];
        $value['payment_type'] = $order['payment_type'];
        $value['order_title'] = $order['title'];

        //判断订单退款是否存在
        if (!empty($refund_exist = $this->refund->findOne('order_id', $order_id))) {
            //验证状态是否可以更改
            if ($refund_exist['refund_status'] != 2) {
                throw new \Exception('当前退款状态不允许修改！');
            }
            //更新退款信息
            $this->refund->update('order_id', $order_id, $value);
        } else {
            //加入退款信息
            $this->refund->create($value);
        }

        //更新订单状态
        $this->order->update('order_id', $order_id, [
            'order_status' => 2,//申请退款状态
        ]);
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
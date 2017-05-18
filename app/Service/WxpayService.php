<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use Illuminate\Support\Facades\Auth;
use BrowserDetect;
use App\Payment\Wxpay\Pay\CLogFileHandler;
use App\Payment\Wxpay\Pay\LogWeixin;
use App\Payment\Wxpay\Lib\WxPayRefund;
use App\Payment\Wxpay\Lib\WxPayApi;
use App\Payment\Wxpay\Lib\WxPayUnifiedOrder;
use App\Payment\Wxpay\Lib\NativePay;
use App\Payment\Wxpay\Lib\WxPayOrderQuery;
use Illuminate\Support\Facades\Log;

class WxpayService implements PayInterfaces
{
    protected $order;
    protected $refund;

    public function __construct(OrderRepositories $order, RefundRepositories $refund)
    {
        $this->order = $order;
        $this->refund = $refund;
    }

    /**
     * 权限验证
     *
     * @return bool
     */
    public function isAdmin()
    {
        try {
            Verfication::admin(WxpayService::class);
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
     * 根据电脑或手机调用不同付款方式
     *
     * @param $post
     * @param $order
     * @return null|void
     * @throws \Exception
     */
    public function Pay($post, $order)
    {
        // 判断是否可以操作本订单
        $this->verfication($order['order_id']);

        //判断订单状态（已付款不再往下执行）
        if ($order['payment_status'] == 1) {
            throw new \Exception('订单已经支付，不要重复支付！');
        }

        //判断电脑端或手机端，调用对应方法
        if (BrowserDetect::isMobile()) {
            $this->wapPay($post);
        } elseif (BrowserDetect::isDesktop() || BrowserDetect::isTablet()) {
            return $this->pagePay($post, $order);
        }
    }

    /**
     * 电脑端支付
     *
     * @param $post
     */
    public function pagePay($array, $order)
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
        $input->SetNotify_url(config('wxpay.NOTIFY_URL'));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("WIDout_trade_no");
        $result = $notify->GetPayUrl($input);
        $url = $result["code_url"] ?? null;

        //判断订单是否已经生成过支付链接
        if (empty($url)) {
            $url = $order['trade_no'];
        } else {
            //记录二维码地址
            $this->order->update('order_number', $array['WIDout_trade_no'], ['trade_no' => $url]);
        }

        //返回支付
        return $url;
    }

    /**
     * 手机端支付
     *
     * @param $post
     */
    public function wapPay($array)
    {
        throw new \Exception('由于微信限制，手机端将无法使用微信付款，请使用支付宝付款！');
    }

    /**
     * 查询订单
     *
     * @param $order_id
     * @throws \Exception
     */
    public function query($order)
    {
        //判断订单是否存在
        if (empty($order)) {
            return false;
        }

        //判断订单号
        if(empty($order["order_number"])) {
            return false;
        }

        //获取信息
        $out_trade_no = $order["order_number"];
        $input = new WxPayOrderQuery();
        $input->SetOut_trade_no($out_trade_no);
        $result = WxPayApi::orderQuery($input);
        return $result;
    }

    /**
     * 提交到微信网关退款
     *
     * @param $data
     * @return bool
     */
    public function refund($refund, $request)
    {
        //判断是否可以操作本订单
        $this->verfication($refund['order_id']);

        //初始化日志
        $logHandler= new CLogFileHandler(__DIR__."/../Payment/Wxpay/logs/".date('Y-m-d').'.log');
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
            $input->SetTotal_fee($total_fee*100);
            $input->SetRefund_fee($refund_fee*100);
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
     * 刷新支付二维码（重新生成订单ID）
     *
     * @param $order_id
     * @return null|void
     * @throws \Exception
     */
    public function refresh($order_id)
    {
        //判断是否可以操作本订单
        $this->verfication($order_id);

        $order = $this->order->findOne('order_id', $order_id);

        //判断订单是否可以操作
        if ($order['payment_status'] == 1) {
            throw new \Exception('订单已经支付，不要重复支付！');
        }

        //刷新订单号
        $user_id = $order['user_id'];
        $order_number = $user_id.date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $this->order->update('order_id', $order_id, ['order_number' => $order_number]);

        //提交重新生成URL
        $order = $this->order->findOne('order_id', $order_id);
        $post['WIDout_trade_no'] = $order_number;
        $post['WIDsubject'] = $order['title'];
        $post['WIDtotal_amount'] = $order['total_amount'];
        $post['WIDbody'] = $order['content'];
        $url = $this->Pay($post, $order);

        return $url;
    }

    public function callback($order_id)
    {
        // 权限验证
        $this->verfication($order_id);

        //订单验证
        $order = $this->order->findOne('order_id', $order_id);
        if ($order['payment_status'] != 1) {
            throw new \Exception('支付未成功！');
        }

        return true;
    }

    /**
     * 接收微信异步数据
     * XML数据
     *
     */
    public function app($input)
    {
        //转为数组
        $app = simplexml_load_string($input);

        //开始判断和操作订单
        if (!empty($app)) {
            if($app->return_code == 'SUCCESS' || $app->result_code == 'SUCCESS') {
                //本地验证订单合法性
                $order_detail = $this->order->findOne('order_number', $app->out_trade_no);
                if ($app->total_fee == ($order_detail['total_amount']*100) &&
                    $app->mch_id == config('wxpay.MCHID') &&
                    $app->appid == config('wxpay.APPID')
                ) {
                    $this->order->update('order_number', $app->out_trade_no, [
                        'payment_type' => 'wxpay',
                        'trade_no' => $app->transaction_id,
                        'payment_status' => 1
                    ]);
                    //成功记录到日志
                    Log::info('wxpay_success_post:'.$input);
                    return 'Success';
                }
            }
        }

        //验证失败记录到日志
        Log::info('wxpay_faile_post:'.$input);
        return 'Faile';
    }

}
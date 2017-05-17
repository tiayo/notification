<?php

namespace App\Http\Controllers\Admin;

use App\Payment\Alipay\Pay\Service\AlipayTradeService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use App\Service\AlipayService;
use App\Service\WeixinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeixinController extends Controller
{

    protected $request;
    protected $order;
    protected $refund;
    protected $weixin;

    public function __construct(Request $request, OrderRepositories $order, RefundRepositories $refund, WeixinService $weixin)
    {
        $this->request = $request;
        $this->order = $order;
        $this->refund = $refund;
        $this->weixin = $weixin;
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
        $app = simplexml_load_string($input);

        if (!empty($app)) {
            if($app->return_code == 'SUCCESS' || $app->result_code == 'SUCCESS') {
                //本地验证订单合法性
                $order_detail = $this->order->findOne('order_number', $app->out_trade_no);
                if ($app->total_fee == ($order_detail['total_amount']*100) &&
                    $app->mch_id == config('weixin.MCHID') &&
                    $app->appid == config('weixin.APPID')
                ) {
                    $this->order->update('order_number', $app->out_trade_no, [
                        'payment_type' => 'weixin',
                        'trade_no' => $app->transaction_id,
                        'payment_status' => 1
                    ]);
                    //成功记录到日志
                    Log::info('weixin_success_post:'.$input);
                    return response('success');
                }
            }
        }
        //验证失败记录到日志
        Log::info('weixin_faile_post:'.$input);
        return response('faile', 403);
    }

    /**
     * 查询订单
     *
     * @param $order_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function query($order_id)
    {
        $order = $this->order->findOne('order_id', $order_id);
        try {
            $query = $this->weixin->query($order);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
        return $query;
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

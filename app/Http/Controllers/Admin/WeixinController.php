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
     */
    public function pay()
    {
        $post = $this->request->all();
        $pay_url = $this->weixin->Pay($post);

        return view('payment.weixin_pay', [
            'pay_url' => $pay_url,
        ]);
    }

    /**
     * 订单退款视图
     *
     * @param $order_id
     *
     */
    public function refundView($order_id)
    {
        try {
            $order = $this->weixin->refundView($order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
        return view('payment.refund_apply', [
                'order' => $order,
                'refund' => $this->refund->findOne('order_id', $order['order_id']),
                'refund_number' => $order_id.strtotime(date('YmdHis')),
            ]
        );
    }

    /**
     * 发起退款
     * 有权限验证
     *
     * @param $order_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function refundAction($order_id)
    {
        $this->validate($this->request, [
            'out_trade_no' => 'required',
            'trade_no' => 'required',
            'refund_amount' => "required",
            'refund_reason' => 'required',
            'refund_number' => 'required|integer',
        ]);

        $data = $this->request->all();
        try {
            $this->weixin->refundAction($data, $order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('refund_page', ['page' => 1]);
    }

    /**
     * 接收微信异步数据
     * XML数据
     *
     */
    public function app()
    {
        $app = file_get_contents('php://input');
        $app = simplexml_load_string($app);

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
                    Log::info('weixin_success_post:'.json_encode($app));
                    return response('success');
                }
            }
        }
        //验证失败记录到日志
        Log::info('weixin_faile_post:'.json_encode($app));
        return response('faile');
    }

}

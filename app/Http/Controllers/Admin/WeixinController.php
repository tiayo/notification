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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use App\Service\AlipayService;
use Illuminate\Http\Request;

class AlipayController extends Controller
{

    protected $request;
    protected $config;
    protected $alipay;
    protected $order;
    protected $refund;

    public function __construct(Request $request,
                                AlipayService $alipay,
                                OrderRepositories $order,
                                RefundRepositories $refund
    )
    {
        $this->request = $request;
        $this->alipay = $alipay;
        $this->order = $order;
        $this->refund = $refund;
    }

    /**
     * 跳转到支付宝网关付款
     * 过滤已经付款的订单
     *
     */
    public function pay()
    {
        $post = $this->request->all();
        $order = $this->order->findOne('order_number', $post['WIDout_trade_no']);
        $this->alipay->Pay($post, $order);
    }

    /**
     * 接收返回数据并验证
     * 验证通过现在验证通过view
     * 否则显示失败view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function callback()
    {
        $callback = $this->request->all();

        if ($this->alipay->callback($callback)) {
            return view('payment.success', [
                'order' => $this->order->findOne('order_number', $callback['out_trade_no']),
                'status' => app('App\Http\Controllers\Controller'),
            ]);
        }

        return view('payment.faile', [
            'order' => $this->order->findOne('order_number', $callback['out_trade_no']),
            'status' => app('App\Http\Controllers\Controller'),
        ]);
    }


    /**
     * 查询订单付款状态
     *
     * @param $order_id
     * @return string
     */
    public function query($order_id)
    {
        $order = $this->order->findOne('order_id', $order_id);
        try {
            $query = $this->alipay->query($order);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

       dd($query);
    }

    /**
     * 接收支付宝主动发送的数据
     */
    public function app()
    {
        $app = $this->request->all();
        return response($this->alipay->app($app));
    }
}

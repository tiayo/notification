<?php

namespace App\Http\Controllers\Admin;

use App\Alipay\Wappay\Service\AlipayTradeService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Service\AlipayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AlipayController extends Controller
{

    protected $request;
    protected $config;
    protected $alipay;
    protected $order;

    public function __construct(Request $request, AlipayService $alipay, OrderRepositories $order)
    {
        $this->request = $request;
        $this->alipay = $alipay;
        $this->order = $order;
    }

    /**
     * 确认付款页面
     *
     * @param $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alipay($order)
    {
        $order = $this->order->findOne($order);
        return view('payment.alipay_pay', [
            'WIDout_trade_no' => $order['order_id'],
            'WIDsubject' => $order['title'],
            'WIDtotal_amount' => $order['total_amount'],
            'WIDbody' => $order['content']
        ]);
    }

    /**
     * 跳转到支付宝网关付款
     */
    public function pay()
    {
        $post = $this->request->all();
        $this->alipay->pay($post);
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
                'order' => $this->order->findOne($callback['out_trade_no']),
                'callback' => $callback,
            ]);
        }

        return view('payment.faile', [
            'order' => $this->order->findOne($callback['out_trade_no']),
            'callback' => $callback,
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
        if ($this->query($order_id)) {
            return '付款成功!';
        }
        return '未付款';
    }

    /**
     * 接收支付宝主动发送的数据
     */
    public function app()
    {
        $alipaySevice = new AlipayTradeService();
        $app = $this->request->all();
        $result = $alipaySevice->check($app);
        if ($result) {
            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                $this->order->update('order_id', $app['out_trade_no'], [
                    'payment_type' => 'alipay',
                    'trade_no' => $app['trade_no'],
                    'payment_status' => 1
                ]);
            }
            //成功记录到日志
            Log::info('alipay_success_post:'.json_encode($app));
        }
    }
}

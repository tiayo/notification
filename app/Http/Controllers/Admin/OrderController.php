<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $request;
    protected $order;

    public function __construct(Request $request, OrderService $order)
    {
        $this->request = $request;
        $this->order = $order;
    }

    /**
     * 订单列表页
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page)
    {
        // 所有订单
        $list_order = $this->order->show($page, Config('site.page'));

        // 订单总数
        $count = $this->order->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        return view('home.order', [
            'list_order' => $list_order,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'status' => app('App\Http\Controllers\Controller'),
            'is_admin' => $this->order->isAdmin(),
        ]);
    }

    /**
     * 订单确认付款页面
     *
     * @param $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($order_id)
    {
        try {
            $order = $this->order->findOrderAndUser($order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
        return view('payment.alipay_pay', [
            'order' => $order,
            'judge' => app('App\Http\Controllers\Controller'),
            'WIDout_trade_no' => $order['order_number'],
            'WIDsubject' => $order['title'],
            'WIDtotal_amount' => $order['total_amount'],
            'WIDbody' => $order['content']
        ]);
    }
}

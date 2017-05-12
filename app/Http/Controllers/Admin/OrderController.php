<?php

namespace App\Http\Controllers\Admin;

use App\Alipay\Wappay\Service\AlipayTradeService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Service\AlipayService;
use App\Service\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{

    protected $request;
    protected $order;

    public function __construct(Request $request, OrderService $order)
    {
        $this->request = $request;
        $this->order = $order;
    }

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
        ]);
    }
}

<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $order;

    public function __construct(OrderRepositories $order)
    {
        $this->order = $order;
    }

    public function isAdmin()
    {
        //权限验证
        try {
            Verfication::admin(OrderService::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 前端展示数据
     * 权限不同调用管理员方法
     *
     * @param $page
     * @param $num
     * @return array
     */
    public function show($page, $num)
    {
        //权限验证
        if ($this->isAdmin()) {
            return $this->order->adminShow($page, $num);
        }

        return $this->order->userShow($page, $num);
    }

    /**
     * 统计订单总数
     *
     * @return mixed
     */
    public function count()
    {
        //权限验证
        if ($this->isAdmin()) {
            return $this->order->adminCount();
        }
        return $this->order->userCount();
    }

}
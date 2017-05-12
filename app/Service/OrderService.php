<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $order;
    protected $is_admin;

    public function __construct(OrderRepositories $order)
    {
        $this->order = $order;
    }

    public function isAdmin()
    {
        //权限验证
        $this->is_admin = true;
        try {
            Verfication::admin(OrderService::class);
        } catch (\Exception $e) {
            $this->is_admin = false;
        }
    }

    /**
     * 前端展示数据
     * 管理员权限调用管理员方法
     *
     * @param $page
     * @param $num
     * @return array
     */
    public function show($page, $num)
    {
        //权限验证
        $this->isAdmin();

        if ($this->is_admin) {
            return $this->adminShow($page, $num);
        }

        return $this->userShow($page, $num);
    }

    /**
     * 前端显示数据
     * 管理员方法
     *
     * @param $page
     * @param $num
     * @return array
     */
    public function adminShow($page, $num)
    {
        return $this->order->adminShow($page, $num);
    }

    /**
     * 前端显示方法
     * 普通用户方法
     *
     * @param $page
     * @param $num
     * @return array
     */
    public function userShow($page, $num)
    {
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
        $this->isAdmin();

        return $this->order->count();
    }

}
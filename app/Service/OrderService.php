<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use App\Repositories\RefundRepositories;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $order;
    protected $refund;

    public function __construct(OrderRepositories $order, RefundRepositories $refund)
    {
        $this->order = $order;
        $this->refund = $refund;
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
     * 验证用户是否可以操作本条订单
     * 验证失败抛错误
     *
     * @param $order_id
     * @return bool
     * @throws \Exception
     */
    public function verfication($order_id)
    {
        return Verfication::update($this->order->findOne('order_id', $order_id));
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

    /**
     * 查询单个订单并加上用户信息
     * 权限验证
     *
     * @param $order_id
     * @return mixed
     * @throws \Exception
     */
    public function findOrderAndUser($order_id)
    {
        //验证权限
        if (!$this->verfication($order_id)) {
            throw new \Exception('您没有权限访问（代码：1003）！', 403);
        }

        return $this->order->findOrderAndUser('order_id', $order_id);
    }

    /**
     * 退款订单列表
     *
     * @param $page
     * @param $num
     * @return object
     */
    public function refundList($page, $num)
    {
        //权限验证
        if (!$this->isAdmin()) {
           throw new \Exception('拒绝访问！（错误代码：1001）');
        }

        return $this->refund->get($page, $num);
    }

    /**
     * 统计退单订单总数
     *
     * @return mixed
     */
    public function refundCount()
    {
        return $this->refund->countNoWhere();
    }

    /**
     * 查询退款订单并加上用户信息
     *
     * @param $refund_id
     * @return mixed
     */
    public function findRefundAndUser($refund_id)
    {
        return $this->refund->findRefundAndUser('refund_id', $refund_id);
    }

    /**
     * 确认退款是否通过
     *
     * @param $action
     * @return string
     */
    public function configmView($action)
    {
        switch ($action) {
            case 'agree' :
                return '同意';
                break;
            case 'refuse' :
                return '拒绝';
                break;
            default :
                return '未知';
                break;
        }
    }

    /**
     * 同意退款
     *
     * @param $action
     */
    public function refundAgree($request)
    {

    }

    /**
     * 拒绝退款
     *
     * @param $action
     */
    public function refundRefuse($request)
    {
        //更新退款信息
        $data['refund_status'] = 5;
        $data['reply'] = $request['reply'];
        $this->refund->update('refund_id', $request['refund_id'], $data);

        //更新订单信息
        $order_id = $this->refund->findOne('refund_id', $request['refund_id'])['order_id'];
        $value['order_status'] = 4;
        $this->order->update('order_id', $order_id, $value);

        return true;
    }

    public function refundInfo($order_id)
    {
        return $this->refund->findOne('order_id', $order_id);
    }
}
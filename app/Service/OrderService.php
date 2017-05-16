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
    protected $alipay;

    public function __construct(OrderRepositories $order, RefundRepositories $refund, AlipayService $alipay)
    {
        $this->order = $order;
        $this->refund = $refund;
        $this->alipay = $alipay;
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

        $order = $this->order->findOrderAndUser('order_id', $order_id);
        if (empty($order)) {
            throw new \Exception('没有找到该订单（代码：1004）！', 403);
        }
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
    public function configmView($refund_id, $action)
    {
        //判断是否可以拒绝退款
        $this->isRefundSuccess($refund_id);

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
     * 不同支付方式调用不同方法
     *
     * @param $action
     */
    public function refundAgree($request)
    {
        //获取订单信息和付款方式
        $refund = $this->refund->findOne('refund_id', $request['refund_id']);
        //$order = $this->order->findOne('order_id', $refund['order_id']);
        $payment_type = $refund['payment_type'];

        switch ($payment_type) {
            case 'alipay' :
                $this->alipayRedund($refund, $request);
                break;
        }
    }

    /**
     * 支付宝退款方法
     *
     * @param $refund
     * @param $request
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function alipayRedund($refund, $request)
    {
        try {
            return $this->alipay->refund($refund, $request);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    /**
     * 拒绝退款
     * 通用
     *
     * @param $action
     * @return bool
     */
    public function refundRefuse($request)
    {
        $refund_id = $request['refund_id'];

        //判断是否可以拒绝退款
        $this->isRefundSuccess($refund_id);

        //更新退款信息
        $data['refund_status'] = 5;//状态：退款被拒绝
        $data['reply'] = $request['reply'];
        $this->refund->update('refund_id', $refund_id, $data);

        //更新订单信息
        $order_id = $this->refund->findOne('refund_id', $refund_id)['order_id'];
        $value['order_status'] = 4;//状态：退款失败
        $this->order->update('order_id', $order_id, $value);

        return true;
    }

    /**
     * 判断订单是否退款成功
     *
     * @param $refund_id
     * @return bool
     * @throws \Exception
     */
    public function isRefundSuccess($refund_id)
    {
        $reund = $this->refund->findOne('refund_id', $refund_id);
        if ($reund['refund_status'] == 3) {
            throw new \Exception('该订单已经退款成功了！');
        }

        return true;
    }

    /**
     * 获取退款订单信息
     *
     * @param $order_id
     * @return mixed
     */
    public function refundInfo($order_id)
    {
        return $this->refund->findOne('order_id', $order_id);
    }

    /**
     * 获取退款链接
     *
     * @param $refund
     * @return string
     */
    public function refundUrl($order_id)
    {
        $order = $this->order->findOne('order_id', $order_id);
        switch ($order['payment_type']) {
            case 'alipay' :
                return "/admin/alipay/refund/$order_id";
                break;
            case 'weixin' :
                return "/admin/weixin/refund/$order_id";
                break;
        }
    }
}
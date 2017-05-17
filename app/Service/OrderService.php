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
    protected $weixin;

    public function __construct(OrderRepositories $order, RefundRepositories $refund, AlipayService $alipay, WeixinService $weixin)
    {
        $this->order = $order;
        $this->refund = $refund;
        $this->alipay = $alipay;
        $this->weixin = $weixin;
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

        return $order;
    }

    /**
     * 退款视图
     * 订单状态为1,2 + 付款状态为1 的订单才可以发起退款
     * 退款订单存在则判断退款状态（退款状态为2：申请退款 才可以修改）
     *
     * @param $order_id
     * @return mixed
     * @throws \Exception
     */
    public function refundApply($order_id)
    {
        //验证状态是否可以操作
        if (!empty($refund_exist = $this->refund->findOne('order_id', $order_id))) {
            if ($refund_exist['refund_status'] != 2) {
                throw new \Exception('当前退款状态不允许修改！');
            }
        }

        //权限验证
        $this->verfication($order_id);

        $order = $this->order->findOne('order_id', $order_id);

        if ($order['order_status'] != 1 && $order['order_status'] != 2) {
            throw new \Exception('当前订单状态不允许退款，请联系管理员。');
        }

        if ($order['payment_status'] != 1) {
            throw new \Exception('当前订单付款状态不允许退款，请确定订单已经完成付款。');
        }

        return $order;
    }


    /**
     * 发起退款
     * 金额不超过订单总额，并且限制小数点为两位
     * 退款订单存在则执行更新方法（退款状态为2：申请退款 才可以修改）
     *
     * @param $data
     */
    public function refundSave($data, $order_id)
    {
        //权限验证
        $this->verfication($order_id);

        //初始化
        $value = [];

        //验证订单状态、付款状态是否符合条件
        $order = $this->refundApply($order_id);

        //验证订单正确性
        if ($data['out_trade_no'] != $order['order_number'] ||
            $data['trade_no'] != $order['trade_no']
        ) {
            throw new \Exception('订单本地验证失败！');
        }

        //验证退款金额
        $refund_amount = (float)$data['refund_amount'];
        $decimal = explode('.', (string)$refund_amount)[1] ?? null;
        if (strlen($decimal) > 2 || $refund_amount > $order['total_amount'] || $refund_amount <= 0) {
            throw new \Exception('退款金额验证失败！');
        }

        //提交数组
        $value['refund_number'] = $data['refund_number'];
        $value['user_id'] = $order['user_id'];
        $value['order_id'] = $order_id;
        $value['order_number'] = $order['order_number'];
        $value['trade_no'] =  $order['trade_no'];
        $value['refund_amount'] = $data['refund_amount'];
        $value['refund_reason'] = $data['refund_reason'];
        $value['payment_type'] = $order['payment_type'];
        $value['order_title'] = $order['title'];

        //判断订单退款是否存在
        if (!empty($refund_exist = $this->refund->findOne('order_id', $order_id))) {
            //验证状态是否可以更改
            if ($refund_exist['refund_status'] != 2) {
                throw new \Exception('当前退款状态不允许修改！');
            }
            //更新退款信息
            $this->refund->update('order_id', $order_id, $value);
        } else {
            //加入退款信息
            $this->refund->create($value);
        }

        //更新订单状态
        $this->order->update('order_id', $order_id, [
            'order_status' => 2,//申请退款状态
        ]);
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
        $refund = $this->refund->findRefundAndOrder('refund_id', $request['refund_id']);

        //$order = $this->order->findOne('order_id', $refund['order_id']);
        $payment_type = $refund['payment_type'];

        switch ($payment_type) {
            case 'alipay' :
                $this->alipayRedund($refund, $request);
                break;
            case 'weixin' :
                $this->weixinRefund($refund, $request);
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
     * 微信退款方法
     *
     * @param $refund
     * @param $request
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function weixinRefund($refund, $request)
    {
        try {
            return $this->weixin->refund($refund, $request);
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
}
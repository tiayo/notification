<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RefundRepositories;
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

        return view('home.order_list', [
            'list_order' => $list_order,
            'count' => $count,
            'page' => $page,
            'max_page' => $max_page,
            'status' => app('App\Http\Controllers\Controller'),
            'is_admin' => can('admin'),
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

        $refund = $this->order->refundInfo($order_id);

        return view('payment.pay', [
            'order' => $order,
            'refund' => $refund,
            'judge' => app('App\Http\Controllers\Controller'),
            'WIDout_trade_no' => $order['order_number'],
            'WIDsubject' => $order['title'],
            'WIDtotal_amount' => $order['total_amount'],
            'WIDbody' => $order['content'],
        ]);
    }

    /**
     * 订单退款视图
     *
     * @param $order_id
     *
     */
    public function refundApply($order_id)
    {
        try {
            $order = $this->order->refundApply($order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
        return view('payment.refund_apply', [
                'order' => $order,
                'refund' => $this->order->refundInfo($order_id),
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
    public function refundSave($order_id)
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
            $this->order->refundSave($data, $order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('order_page', ['page' => 1]);
    }

    /**
     * 退款申请列表
     * 管理员权限访问
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundList($page)
    {
        // 所有退款
        try {
            $list_refund = $this->order->refundList($page, Config('site.page'));
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        // 订单总数
        $count = $this->order->refundCount();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        return view('payment.refund_list', [
            'list_refund' => $list_refund,
            'count' => $count,
            'page' => $page,
            'max_page' => $max_page,
            'status' => app('App\Http\Controllers\Controller'),
            'is_admin' => can('admin'),
        ]);
    }

    /**
     * 退款详情
     * 中间件鉴权
     *
     * @param $refund_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundView($refund_id)
    {
        $refund = $this->order->findRefundAndUser($refund_id);
        return view('payment.refund_view', [
            'refund' => $refund,
            'judge' => app('App\Http\Controllers\Controller'),
        ]);
    }

    /**
     * 同意或拒绝退款
     *
     * @param $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function configmView($action)
    {
        //退款ID
        $refund_number = $this->request->get('refund_number');

        //退款确认类型（同意、拒绝）
        try {
            $action_value = $this->order->configmView($refund_number, $action);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return view('payment.refund_confirm', [
            'action' => $action,
            'action_value' => $action_value,
            'refund_number' => $refund_number,
            'refund_id' => app('App\Repositories\RefundRepositories')->findOne('refund_number', $refund_number)['refund_id'],
        ]);
    }

    /**
     * 进行退款操作
     * 中间件鉴权
     *
     * @param $action
     */
    public function refundAction($action)
    {
        $this->validate($this->request, [
            'reply' => 'required',
        ]);

        $request = $this->request->all();

        if ($action == 'agree') {
            try {
                $this->order->refundAgree($request);
            } catch (\Exception $e) {
                return response($e->getMessage());
            }
            return redirect()->route('refund_page', ['page' => 1]);
        } else if ($action == 'refuse') {
            if ($this->order->refundRefuse($request)) {
                return redirect()->route('refund_page', ['page' => 1]);
            }
        }

    }
}

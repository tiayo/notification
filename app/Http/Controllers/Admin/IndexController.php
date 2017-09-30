<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\IndexService;
use App\Services\MessageService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $index;
    protected $request;

    public  function __construct(IndexService $index, Request $request)
    {
        $this->index = $index;
        $this->request = $request;
    }

    /**
     * 显示后台框架
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserRepository $user, TaskService $task, OrderRepository $order, MessageService $message)
    {
        //验证是否管理员true,false
        $admin = can('admin');

        //获取上次登录时间
        $next_login_time = $user->selectFirst('next_login_time', 'id', Auth::id())['next_login_time'];

        //获取5条任务
        $task_list = $task->userShow(1, 5);

        //获取3条订单
        $order_list = $order->userShow(1, 3);

        //获取五条收到的消息
        $message_list = $message->received(1, 5);

        return view('admin.index', [
            'user_name' => Auth::user()['name'],
            'admin' => $admin,
            'next_login_time' => $next_login_time ? : date('Y-m-d H:i:s'),
            'tasks' => $task_list,
            'orders' => $order_list,
            'message_list' => $message_list,
            'status' => app('App\Http\Controllers\Controller'),
            'message' => app('App\Services\MessageService'),
        ]);
    }

    /**
     * 赞助页面
     */
    public function sponsor()
    {
        $money = $this->request->get('money');
        if (empty($money)) {
            return view('admin.sponsor');
        }

        //新建订单
        $order = $this->index->sponsor($money);

        //转到订单详情页
        return redirect()->route('order_view', ['order_id' => $order->order_id]);
    }

    /**
     * 后台搜索入口
     *
     * @return array
     */
    public function searchSlidebar()
    {
        $keyword = $this->request->get('search_sidebar');

        try {
            $response = $this->index->searchSlidebar($keyword);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 401);
        }

        return $this->jsonResponse($response);
    }
}

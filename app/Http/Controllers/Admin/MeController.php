<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Services\ArticleService;
use App\Services\MeService;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    protected $request;
    protected $me;

    public function __construct(Request $request, MeService $me)
    {
        $this->request = $request;
        $this->me = $me;
    }

    public function view(TaskService $task, ArticleService $article, OrderRepository $order)
    {
        //获取1条订单
        $orders = $order->userShow(1, 1);

        //取1条任务
        $tasks = $task->userShow(1, 1);

        //取1条文章
        $articles = $article->userShow(1);

        return view('home.me', [
            'user' => Auth::user(),
            'profile' => User::find(Auth::id())->profile,
            'task_count' => $task->count(),
            'article_count' => $article->count(),
            'status' => app('App\Http\Controllers\Controller'),
            'orders' => $orders,
            'tasks' => $tasks,
            'articles' => $articles
        ]);
    }

    public function updateView()
    {
        //获取用户信息
        $profile = User::find(Auth::id())->profile;

        //获取现有地址
        $address = $this->me->address($profile);

        return view('home.me_update', [
            'user' => Auth::user(),
            'profile' => $profile,
            'address' => $address,
        ]);
    }

    public function update()
    {
        $data = $this->request->all();

        try{
            $this->me->update($data);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 401);
        }

        return redirect()->route('me_view');
    }
}
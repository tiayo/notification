<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Service\ArticleService;
use App\Service\TaskService;
use App\User;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public function view(TaskService $task, ArticleService $article, OrderRepositories $order)
    {
        //获取1条订单
        $orders = $order->userShow(1, 1);

        //取1条文章
        $tasks = $task->userShow(1, 1);

        //取1条任务
        $articles = $article->userShow(1, 1);

        return view('home.me', [
            'user' => Auth::user(),
            'profile' => User::find(Auth::id())->profile[0],
            'task_count' => $task->count(),
            'article_count' => $article->count(),
            'status' => app('App\Http\Controllers\Controller'),
            'orders' => $orders,
            'tasks' => $tasks,
            'articles' => $articles
        ]);
    }
}
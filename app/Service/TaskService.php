<?php

namespace App\Service;

use App\Repositories\TackRepositories;
use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;

class TaskService
{

    protected $user_id;
    protected $task;
    protected $user;

    public function __construct(TackRepositories $tack, UserRepositories $user)
    {
        $this->user_id = Auth::id();
        $this->task = $tack;
        $this->user = $user;
    }

    /**
     * 获取任务列表
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function show($page, $num)
    {
        if ($this->user->find($this->user_id)->can('Admin')) {
            return $this->adminShow($page, $num);
        }

        return $this->adminShow($page, $num);
    }

    /**
     * 普通用户获取任务列表
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function userShow($page, $num)
    {
        return $this->task
            ->findMulti('id', $this->user_id, $page, $num)
            ->toArray();
    }

    /**
     * 管理员获取任务列表
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function adminShow($page, $num)
    {
        return $this->task
            ->getAll($page, $num)
            ->toArray();
    }

    public function count()
    {
        return $this->task->count();
    }
}

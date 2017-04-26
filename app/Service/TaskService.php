<?php

namespace App\Service;

use App\Repositories\TaskRepositories;
use App\Repositories\UserRepositories;
use App\Task;
use App\Facades\Verfication;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected $task;
    protected $user;
    protected $verfication;

    public function __construct(TaskRepositories $tack, UserRepositories $user)
    {
        $this->task = $tack;
        $this->user = $user;
    }

    /**
     * 获取任务列表
     * 根据权限执行不同操作
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function show($page, $num)
    {
        try{
            Verfication::admin(Task::class);
        } catch (\Exception $e) {
            return $this->userShow($page, $num);
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
            ->findMulti('id', Auth::id(), $page, $num)
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

    /**
     * 统计任务总数量
     * 权限不同执行不同操作
     *
     * @return mixed
     */
    public function count()
    {
        try{
            Verfication::admin(Task::class);
        } catch (\Exception $e) {
            return $this->task->userCount($this->user_id);
        }

        return $this->task->adminCount();
    }

    public function store($data, $category_id)
    {
        $data['category'] = $category_id;
        $data['user_id'] = Auth::id();

        return $this->task->store($data);
    }
}

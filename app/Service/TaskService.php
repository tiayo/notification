<?php

namespace App\Service;

use App\Repositories\CategoryRepositories;
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
    protected $category;

    public function __construct(TaskRepositories $tack, UserRepositories $user, CategoryRepositories $category)
    {
        $this->task = $tack;
        $this->user = $user;
        $this->category = $category;
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
     * @return array
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
     * @return array
     */
    public function adminShow($page, $num)
    {
        return $task = $this->task
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
            return $this->task->userCount(Auth::id());
        }

        return $this->task->adminCount();
    }

    /**
     * 插入任务
     *
     * @param $data
     * @param $category_id
     * @return mixed
     */
    public function store($data, $category_id)
    {
        $data['category'] = $category_id;
        $data['user_id'] = Auth::id();

        return $this->task->store($data);
    }

    public function findFirst($id)
    {
        return $this->task->findOne('id', $id);
    }
}

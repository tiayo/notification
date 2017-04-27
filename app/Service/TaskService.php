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
            ->findMulti('user_id', Auth::id(), $page, $num)
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

    /**
     * 根据任务id查找任务
     *
     * @param $id
     * @return mixed
     */
    public function findFirst($id, $value = '*')
    {
        return $this->task->findOne('task_id', $id, $value);
    }

    /**
     * 更新任务
     *
     * @param $data
     * @param $id
     */
    public function update($data, $task_id)
    {
        //权限验证
        $this->verfication($task_id);

        //权限验证通过
        $value['title'] = $data['title'];
        $value['start_time'] = $data['start_time'];
        $value['end_time'] = empty($data['end_time']) ? null : $data['end_time'];
        $value['plan'] = $data['plan'];
        $value['phone'] = $data['phone'];
        $value['email'] = $data['email'];
        $value['content'] = $data['content'];

        return $this->task->update($value, $task_id);
    }

    /**
     * 删除任务
     * 需要通过权限验证
     * 验证失败抛403
     *
     * @param $task_id
     */
    public function destroy($task_id)
    {
        //权限验证
        $this->verfication($task_id);

        //权限验证通过
        $this->task->destroy('task_id', $task_id);
    }

    /**
     * checkbox事件
     * 进行批量删除及选择修改
     * 删除需要权限验证
     *
     * @param $post
     */
    public function selectEvent($post)
    {
        $judge = $post['judge'];
        if ($judge == 'modified') {
            return $this->selectModified($post['check'][0]);
        } else if ($judge == 'delete') {
            return $this->selectDelete($post['check']);
        }

        return redirect()->route('task_page', ['page' => 1]);
    }

    /**
     * checkbox 修改事件
     *
     * @param $task_id
     */
    public function selectModified($task_id)
    {
        $task = $this->findFirst($task_id, 'category');
        return redirect()->route('task_update', ['category' => $task['category'], 'task_is' => $task_id]);
    }

    /**
     * checkbox 删除事件
     * 有权限验证
     * 只可以删除自己的任务，违规id会被忽略
     *
     * @param $check
     */
    public function selectDelete($check)
    {
        foreach ($check as $item) {
            try {
                $this->destroy($item);
            } catch (\Exception $e) {
                continue;
            }
        }
        return redirect()->route('task_page', ['page' => 1]);
    }

    /**
     * 验证用户是否可以操作本条权限
     * 验证失败抛错误
     *
     * @param $task_id
     * @return mixed
     */
    public function verfication($task_id)
    {
        return Verfication::taskUpdate($this->task->findOne('task_id', $task_id));
    }
}

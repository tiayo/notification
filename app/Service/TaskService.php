<?php

namespace App\Service;

use App\Repositories\CategoryRepositories;
use App\Repositories\TaskRepositories;
use App\Repositories\UserRepositories;
use App\Task;
use App\Facades\Verfication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class TaskService
{
    protected $task;
    protected $user;
    protected $verfication;
    protected $category;
    protected $request;

    public function __construct(
        TaskRepositories $tack,
        UserRepositories $user,
        CategoryRepositories $category,
        Request $request
    )
    {
        $this->task = $tack;
        $this->user = $user;
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * 获取任务列表
     * 根据权限执行不同操作
     *
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
     *
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
     *
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

    public function storeOrUpdateView($category_id, $task_id)
    {
        if (!empty($task_id)) {
            return $this->updateView($category_id, $task_id);
        }
        return $this->storeView($category_id);
    }

    /**
     * 返回插入任务视图需要的数据
     *
     * @param $category_id
     * @param $task_id
     * @return mixed
     */
    public function storeView($category_id)
    {
        $result['old_input'] = $this->request->session()->get('_old_input');
        $result['uri'] = route('task_add_post', ['category' => $category_id]);
        return $result;
    }

    /**
     * 返回更新试图需要的数据
     *
     * @param $category_id
     * @param $task_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($category_id, $task_id)
    {
        //验证权限
        if (!$this->verfication($task_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        $result['old_input'] = $this->findFirst($task_id);
        $result['uri'] = route('task_update_post', ['category' => $category_id, 'id' => $task_id]);

        return $result;
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
        //验证权限
        if (!$this->verfication($task_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        //权限验证通过
        $value['title'] = $data['title'];
        $value['start_time'] = $data['start_time'];
        $value['end_time'] = empty($data['end_time']) ? null : $data['end_time'];
        $value['plan'] = $data['plan'];
        $value['phone'] = $data['phone'];
        $value['email'] = $data['email'];
        $value['content'] = $data['content'];
        $value['task_status'] = 1;

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
        //验证权限
        if (!$this->verfication($task_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        //权限验证通过
        $this->task->destroy('task_id', $task_id);
    }

    /**
     * checkbox事件
     * 进行批量删除及选择修改
     * 删除需要权限验证
     *
     * @param $post
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectModified($task_id)
    {
        $task = $this->findFirst($task_id, 'category');
        return redirect()->route('task_update', ['category' => $task['category'], 'task' => $task_id]);
    }

    /**
     * checkbox 删除事件
     * 有权限验证
     * 只可以删除自己的任务，违规id会被忽略
     *
     * @param $check
     * @return \Illuminate\Http\RedirectResponse
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
        return Verfication::update($this->task->findOne('task_id', $task_id));
    }
}

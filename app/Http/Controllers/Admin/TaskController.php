<?php

namespace App\Http\Controllers\Admin;

use App\Events\AddTaskEvent;
use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\IndexService;
use App\Service\TaskService;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    protected $category;
    protected $all_category;
    protected $request;
    protected $task;
    protected $mail;

    public function __construct(CategoryService $category, Request $request, TaskService $task)
    {
        $this->category = $category;
        $this->all_category = $category->getSelect();
        $this->request = $request;
        $this->task = $task;
    }

    /**
     * 添加\更新任务视图
     * 更新操作有权限认证，没有权限抛403
     * @param $category_id
     * @param null $task_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeOrUpdateView($category_id, $task_id = null)
    {
        //获取当前栏目
        $current = $this->category->current($category_id);

        //当前栏目别名
        $category = $current['alias'];

        //填入表格的内容及post提交url
        try {
            $result = $this->task->storeOrUpdateView($category_id, $task_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return view("home.$category", [
            'all_category' => $this->all_category,
            'current' => $current,
            'old_input' => $result['old_input'],
            'uri' => $result['uri'],
            'plan' => 'App\Http\Controllers\Controller',
        ]);
    }

    /**
     *  添加/更新任务
     *  插入错误抛相应错误和错误代码，默认403
     *  更新操作有权限认证，没有权限抛403
     *  post请求
     *
     * @param $category_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeORupdate($id, $task_id = null)
    {
        $this->validate($this->request, [
            'title' => 'bail|required',
            'start_time' => 'bail|required|date',
            'end_time' => 'date',
            'plan' => 'required|integer',
            'phone' => 'bail|required|integer',
            'email' => 'bail|required|email',
            'content' => 'bail|required',
        ]);

        try {
            if (empty($task_id)) {
                $result = $this->task->store($this->request->all(), $id);
                $this->sendEmailTaskAdd($result['task_id']);
            } else {
                $this->task->update($this->request->all(), $task_id);
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }
        return redirect()->route('task_page', ['page' => 1]);

    }

    /**
     * 显示所有我的任务
     *
     * @return array
     */
    public function show($page)
    {
        //所有任务
        $list_task = $this->task->show($page, Config('site.page'));

        //任务数量
        $count = $this->task->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = IndexService::admin();

        return view('home.task_list',[
            'list_task' => $list_task,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'all_category' => $this->all_category,
            'admin' => $admin,
            'plan' => 'App\Http\Controllers\Controller',
        ]);
    }

    /**
     *  删除任务
     *  有权限认证，没有权限抛403
     *  插入错误抛相应错误和错误代码，默认403
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($task_id)
    {
        try {
            $this->task->destroy($task_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        return redirect()->route('task_page', ['page' => 1]);
    }

    /**
     * 新建任务发送邮件
     *
     * @param $task_id
     */
    public function sendEmailTaskAdd($task_id)
    {
        $task = $this->task->findFirst($task_id);

        event(new AddTaskEvent($task));
    }

    /**
     * checkbox事件
     * 进行批量删除及选择修改
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function selectEvent()
    {
        return $this->task->selectEvent($this->request->all());
    }
}

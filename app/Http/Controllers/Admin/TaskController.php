<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $category;
    protected $all_category;
    protected $request;
    protected $task;

    public function __construct(CategoryService $category, Request $request, TaskService $task)
    {
        $this->category = $category;
        $this->all_category = $category->getSelect();
        $this->request = $request;
        $this->task = $task;
    }

    /**
     * 添加任务视图
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeView($category_id)
    {
        //获取当前栏目
        $current = $this->category->current($category_id);

        //当前栏目别名
        $category = $current['alias'];

        return view("home.$category", [
            'all_category' => $this->all_category,
            'current' => $current,
            'old_input' => $this->request->session()->get('_old_input'),
        ]);
    }

    /**
     * 添加任务
     * post请求
     *
     * @param $category_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store($category_id)
    {
        $this->validate($this->request, [
            'title' => 'bail|required',
            'start_time' => 'bail|required|date',
            'end_time' => 'date',
            'phone' => 'bail|required|integer',
            'email' => 'bail|required|email',
            'content' => 'bail|required',
        ]);

        try{
            $this->task->store($this->request->all(), $category_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
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

        return view('home.list',[
            'list_task' => $list_task,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'all_category' => $this->all_category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

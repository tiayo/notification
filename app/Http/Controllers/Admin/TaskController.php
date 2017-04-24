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

    public function __construct(CategoryService $category)
    {
        $this->category = $category;
        $this->all_category = $category->getSelect();
    }

    /**
     * 添加任务
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($category_id)
    {
        //获取当前栏目
        $current = $this->category->current($category_id);

        //当前栏目别名
        $category = $current['alias'];

        return view("home.$category", [
            'all_category' => $this->all_category,
            'current' => $current,
        ]);
    }

    /**
     * 显示所有我的任务
     *
     * @return array
     */
    public function show($page, TaskService $task)
    {
        //所有任务
        $list_task = $task->show($page, Config('site.page'));

        //任务数量
        $count = $task->count();

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

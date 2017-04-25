<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\TaskService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;
    protected $all_category;
    protected $request;

    public function __construct(CategoryService $category, Request $request)
    {
        $this->category = $category;
        $this->all_category = $category->getSelect();
        $this->request = $request;
    }

    /**
     * 显示分类管理页面
     * 超级管理员才可以访问
     * 普通用户抛403错误
     *
     * @param $page 页码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page)
    {
        // 所有分类
        try{
            $list_category = $this->category->show($page, Config('site.page'));
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        // 任务数量
        $count = $this->category->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        return view('home.category', [
            'list_category' => $list_category,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'all_category' => $this->all_category,
        ]);
    }

    /**
     * 添加分类页面
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeView()
    {
        return view('home.category_add', [
            'all_category' => $this->all_category,
        ]);
    }

    /**
     * 插入新分类
     */
    public function store()
    {
        $this->validate($this->request,[
            'name' => 'bail|required|max:50',
            'parent_id' => 'bail|required|integer',
            'alias' => 'bail|required|max:50'
        ]);

        $name = $this->request->get('name');
        $parent_id = $this->request->get('parent_id');
        $alias = $this->request->get('alias');

        try{
            $this->category->store($name, $parent_id, $alias);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return redirect()->route('category', ['page' => 1]);
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

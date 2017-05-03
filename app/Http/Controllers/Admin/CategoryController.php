<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\VerficationService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;
    protected $all_category;
    protected $request;

    public function __construct(CategoryService $category, Request $request, VerficationService $verfication)
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
            return response($e->getMessage());
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
     * 添加/更新分类页面
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateView($category_id = null)
    {
        if (empty($category_id)) {
            $old_input = $this->request->session()->get('_old_input');
            $uri = route('category_add');
        } else {
            $old_input = $this->category->current($category_id);
            $uri = route('category_update_post', ['category_id' => $category_id]);
        }

        return view('home.category_add', [
            'old_input' => $old_input,
            'all_category' => $this->all_category,
            'uri' => $uri,
            'parent_name' => $this->category->current($old_input['parent_id'])
        ]);
    }

    /**
     * 插入/更新分类
     */
    public function storeOrUpdate($category_id = null)
    {
        $this->validate($this->request,[
            'name' => 'bail|required|max:50',
            'parent_id' => 'bail|required|integer',
            'alias' => 'bail|required|max:50'
        ]);

        $name = $this->request->get('name');
        $parent_id = $this->request->get('parent_id');
        $alias = $this->request->get('alias');

        if (empty($category_id)) {
            $this->category->store($name, $parent_id, $alias);
        } else {
            $old = $this->category->current($category_id);
            $this->category->update($name, $parent_id, $alias, $category_id, $old);
        }

        return redirect()->route('category', ['page' => 1]);
    }


    /**
     * 删除分类
     * 管理员操作成功，返回上一个路由
     *  非管理员抛403错误
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            $this->category->delete($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return redirect()->to($this->getRedirectUrl());
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

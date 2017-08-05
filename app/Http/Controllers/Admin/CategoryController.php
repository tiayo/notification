<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
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
     * 中间件鉴权
     *
     * @param $page 页码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page)
    {
        // 所有分类
        $list_category = $this->category->show($page, Config('site.page'));

        // 任务数量
        $count = $this->category->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        return view('home.category_list', [
            'list_category' => $list_category,
            'count' => $count,
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
            $this->category->storeOrUpdate($name, $parent_id, $alias);
        } else {
            $this->category->storeOrUpdate($name, $parent_id, $alias, $category_id);
        }

        return redirect()->route('category', ['page' => 1]);
    }


    /**
     * 删除分类
     * 中间件鉴权
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //执行
        $this->category->delete($id);

        //执行完毕
        return redirect()->to($this->getRedirectUrl());
    }

    /**
     * checkbox事件
     * 进行批量删除及选择修改
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function selectEvent()
    {
        return $this->category->selectEvent($this->request->all());
    }
}

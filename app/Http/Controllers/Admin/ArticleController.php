<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $article;
    protected $category;
    protected $all_category;
    protected $request;

    public  function __construct(ArticleService $article, CategoryService $category, Request $request)
    {
        $this->article = $article;
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * 列表显示
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取搜索关键词
        $keyword = $this->request->get('keyword');

        //所有文章
        $list_article = $this->article->show(Config('site.page'), $keyword);

        return view('home.article_list',[
            'list_article' => $list_article,
            'admin' => can('admin'),
            'judge' => 'App\Http\Controllers\Controller',
        ]);
    }

    /**
     * 添加任务视图
     *
     * @param $category_id
     * @param null $task_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeView()
    {
        //获取所有分类
        $categories = $this->category->getSimple([
            ['parent_id', '1']
        ], 'name', 'category_id');

        return view("home.article_add", [
            'categories' => $categories,
            'old_input' => session('_old_input'),
            'uri' => route('article_add'),
            'judge' => 'App\Http\Controllers\Controller',
            'type' => 'store',
        ]);
    }

    /**
     * 更新文章视图
     * 操作有权限认证，没有权限抛403
     *
     * @param $article_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($article_id)
    {
        //获取所有分类
        $categories = $this->category->getSimple([
            ['parent_id', '1']
        ], 'name', 'category_id');

        try {
            $old_input = session('_old_input') ?? $this->article->first($article_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view("home.article_add", [
            'categories' => $categories,
            'old_input' => $old_input,
            'uri' => route('article_update', ['article_id' => $article_id]),
            'judge' => 'App\Http\Controllers\Controller',
            'type' => 'update',
        ]);
    }

    /**
     *  添加文章
     *  插入错误抛相应错误和错误代码，默认403
     *  post请求
     *
     * @param $category_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store()
    {
        $this->validate($this->request, [
            'title' => 'bail|required|unique:article',
            'body' => 'bail|required',
            'attribute' => 'bail|required|integer|max:2|min:1',
            'category_id' => 'bail|required|integer',
        ]);

        try {
            $this->article->store($this->request->all());
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('article_list', ['page' => 1]);
    }

    /**
     *  更新文章
     *  更新操作有权限认证，没有权限抛403
     *  post请求
     *
     * @param $category_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update($article_id)
    {
        $this->validate($this->request, [
            'title' => 'bail|required',
            'body' => 'bail|required',
            'category_id' => 'bail|required|integer',
            'attribute' => 'bail|required|integer|max:2|min:1',
        ]);

        try {
            $this->article->update($this->request->all(), $article_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('article_list', ['page' => 1]);
    }

    /**
     * 设置置顶
     * 管理员操作
     * 非管理员抛403错误
     *
     * @param $article_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function top($article_id, $attribute)
    {
        //错误抛错
        try{
            $this->article->top($article_id, $attribute);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('article_list', ['page' => 1]);
    }

    /**
     *  删除文章
     *  有权限认证，没有权限抛403
     *  插入错误抛相应错误和错误代码，默认403
     *
     * @param  int  $article_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($article_id)
    {
        try {
            $this->article->destroy($article_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        return redirect()->route('article_list', ['page' => 1]);
    }
}

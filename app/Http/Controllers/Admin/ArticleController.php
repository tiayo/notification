<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\ArticleService;
use App\Service\CategoryService;
use App\Service\GenerateService;
use App\Service\IndexService;
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
        $this->all_category = $this->category->getSelect();
        $this->request = $request;
    }

    /**
     * 列表显示
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page)
    {
        //所有文章
        $list_article = $this->article->show($page, Config('site.page'));

        //文章数量
        $count = $this->article->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = IndexService::admin();

        return view('home.article_list',[
            'list_article' => $list_article,
            'count' => $count,
            'page' => $page,
            'max_page' => $max_page,
            'all_category' => $this->all_category,
            'admin' => $admin,
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
    public function storeView($category_id)
    {
        //获取当前栏目
        $current = $this->category->current($category_id);

        //填入表格的内容及post提交url
        try {
            $result = $this->article->storeView($category_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return view("home.article_add", [
            'all_category' => $this->all_category,
            'current' => $current,
            'old_input' => $result['old_input'],
            'uri' => $result['uri'],
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
        //获取栏目id
        $category_id = $this->article->findFirst($article_id)['category'];

        //获取当前栏目
        $current = $this->category->current($category_id);

        //填入表格的内容及post提交url
        try {
            $result = $this->article->updateView($article_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return view("home.article_add", [
            'all_category' => $this->all_category,
            'current' => $current,
            'old_input' => $result['old_input'],
            'uri' => $result['uri'],
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
    public function store($category_id)
    {
        $this->validate($this->request, [
            'title' => 'bail|required|unique:article',
            'body' => 'bail|required',
            'attribute' => 'bail|required|integer|max:2|min:1',
        ]);

        try {
            $this->article->store($this->request->all(), $category_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('article_page', ['page' => 1]);
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
            'category' => 'bail|required|integer',
            'attribute' => 'bail|required|integer|max:2|min:1',
        ]);

        try {
            $this->article->update($this->request->all(), $article_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('article_page', ['page' => 1]);
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
        return redirect()->route('article_page', ['page' => 1]);
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

        return redirect()->route('article_page', ['page' => 1]);
    }

    /**
     * 搜索列表
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        //获取参数
        $keyword = $this->request->get('keyword');
        $page = $this->request->get('page');

        //获取业务数据
        $data = $this->article->show($page, Config('site.page'), $keyword);

        //所有文章
        $list_article = $data['data'] ?? [];

        //文章数量
        $count = $data['count'];

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = IndexService::admin();

        return view('home.article_list',[
            'list_article' => $list_article,
            'count' => $count,
            'page' => $page,
            'max_page' => $max_page,
            'all_category' => $this->all_category,
            'admin' => $admin,
            'judge' => 'App\Http\Controllers\Controller',
        ]);
    }
}

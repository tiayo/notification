<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\FrontService;
use function foo\func;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    protected $front;
    protected $category;

    public function __construct(FrontService $front, CategoryService $category)
    {
        $this->front = $front;
        $this->category = $category;
    }

    /**
     * 前端首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取指定条数文章（config/site.app修改）
        $article_list = $this->front->getArticleLimitDesc(config('site.index_page'));

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDesc(5);

        return view('front.index', [
            'article_list' => $article_list,
            'article_top' => $article_top
        ]);
    }

    public function category($category_id)
    {
        //获取指定条数文章（config/site.app修改）
        $article_list = $this->front->getArticleLimitDescCategory($category_id, config('site.index_page'));

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDescCategory($category_id, 5);

        //获取栏目信息
        $category = $this->category->current($category_id);

        return view('front.index', [
            'category' => $category,
            'article_list' => $article_list,
            'article_top' => $article_top
        ]);
    }

    public function article($article_id)
    {
        //获取文章信息
        $article = $this->front->findOneAndCategoryUser($article_id);

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDescCategory($article['category'], 5);

        //获取5条本栏目随机文章
        $article_rand = $this->front->article_rand($article['category'], 5);

        //我的信息
        $me = $this->front->me(Auth::id());

        return view('front.article', [
            'article' => $article,
            'article_top' => $article_top,
            'article_rand' => $article_rand,
            'me' => $me,
        ]);
    }
}
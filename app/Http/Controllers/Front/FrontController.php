<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\FrontService;

class FrontController extends Controller
{
    protected $front;

    public function __construct(FrontService $front)
    {
        $this->front = $front;
    }

    /**
     * 前端首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取10条文章
        $article_list = $this->front->getArticleLimitDesc(10);

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDesc(5);

        return view('front.index', [
            'article_list' => $article_list,
            'article_top' => $article_top
        ]);
    }
}
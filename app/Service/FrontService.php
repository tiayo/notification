<?php

namespace App\Service;

use App\Repositories\ArticleRepositories;

class FrontService
{
    protected $article;

    public function __construct(ArticleRepositories $article)
    {
        $this->article = $article;
    }

    /**
     * 返回限定条数文章
     * 按照article_id倒序排列
     *
     * @param $num
     * @return mixed
     */
    public function getArticleLimitDesc($num)
    {
        return $this->article->getArticleLimitDesc($num);
    }

    /**
     * 返回限定条数的置顶文章（不限制栏目）
     * 按照article_id倒序排列
     *
     * @param $num
     * @return mixed
     */
    public function getArticleTopDesc($num)
    {
        return $this->article->getArticleTopDesc($num);
    }
}
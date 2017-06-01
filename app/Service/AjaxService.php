<?php

namespace App\Service;

use App\Repositories\ArticleRepositories;

class AjaxService
{
    protected $article;

    public function __construct(ArticleRepositories $article)
    {
        $this->article = $article;
    }

    public function moreArticle($category_id, $page)
    {
         return $this->article->moreArticle($category_id, $page)->toArray();
    }
}
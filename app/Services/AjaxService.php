<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class AjaxService
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    public function moreArticle($category_id, $page)
    {
         return $this->article->moreArticle($category_id, $page)->toArray();
    }
}
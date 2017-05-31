<?php

namespace App\Repositories;

use App\Article;

class ArticleRepositories
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getAll($page, $num)
    {
        return $this->article
            ->leftJoin('category', 'article.category', '=', 'category.category_id')
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('article.article_id', 'desc')
            ->get();
    }

    public function getWhere($value = '*', $page, $num)
    {
        return $this->article
            ->select($value)
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('article.article_id', 'desc')
            ->get();
    }

    public function findMulti($option, $value, $page, $num)
    {
        return $this->article
            ->join('category', 'article.category', '=', 'category.category_id')
            ->skip(($page-1)*$num)
            ->take($num)
            ->where($option, $value)
            ->orderBy('article.article_id', 'desc')
            ->get();
    }


    public function findOne($option, $value, $data = '*')
    {
        return $this->article
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function store($value)
    {
        return $this->article
            ->create($value);
    }

    public function adminCount()
    {
        return $this->article->count();
    }

    public function userCount($user_id)
    {
        return $this->article
            ->where('user_id', $user_id)
            ->count();
    }

    public function update($value, $article_id)
    {
        return $this->article
            ->where('article_id', $article_id)
            ->update($value);
    }

    public function destroy($option, $value)
    {
        return $this->article
            ->where($option, $value)
            ->delete();
    }

}
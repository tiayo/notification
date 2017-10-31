<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function find($id)
    {
        return $this->article->find($id);
    }

    public function getArticleGennerate()
    {
        return $this->article
            ->select('article_id', 'category_id')
            ->where('attribute', '<>', '2')
            ->get();
    }

    public function getArticleGennerateWhere($category)
    {
        return $this->article
            ->select('article_id', 'category_id')
            ->where('attribute', '<>', 2)
            ->where('category_id', $category)
            ->get();
    }

    public function adminGet($num)
    {
        return $this->article
            ->orderBy('updated_at', 'desc')
            ->paginate($num);
    }

    public function getSearch($value)
    {
        return $this->article
            ->where('attribute', '<>', '2')
            ->where(function ($query) use($value) {
                $query->where('title', 'like', "%$value%")
                    ->orwhere('abstract', 'like', "%$value%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(config('site.index_page'));
    }

    public function adminSearchGet($num, $keyword)
    {
        return $this->article
            ->where('title', 'like', "%$keyword%")
            ->orderBy('updated_at', 'desc')
            ->paginate($num);
    }

    public function userGet($where, $num)
    {
        return $this->article
            ->where($where)
            ->orderBy('updated_at', 'desc')
            ->paginate($num);
    }

    public function userSearchGet($where, $num, $keyword)
    {
        return $this->article
            ->where($where)
            ->where('title', 'like', "%$keyword%")
            ->orderBy('updated_at', 'desc')
            ->paginate($num);
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->article
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function findOneRand($where, ...$select)
    {
        return $this->article
            ->select($select)
            ->where($where)
            ->inRandomOrder()
            ->first();
    }

    public function findOneAndCategoryUser($option, $value)
    {
        return $this->article
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

    public function getArticleLimitDesc($num)
    {
        return $this->article
            ->where('attribute', '<>', 2)
            ->orderBy('article.updated_at', 'desc')
            ->limit($num)
            ->get();
    }

    public function getArticleTopDesc($num)
    {
        return $this->article
            ->where('attribute', 3)
            ->limit($num)
            ->orderby('updated_at', 'desc')
            ->get();
    }

    public function getArticleLimitDescCategory($category_id, $num)
    {
        return $this->article
            ->where('attribute', '<>', 2)
            ->where('category_id', $category_id)
            ->limit($num)
            ->orderby('article.updated_at', 'desc')
            ->get();
    }

    public function getArticleTopDescCategory($category_id, $num)
    {
        return $this->article
            ->where('attribute', 3)
            ->where('category_id', $category_id)
            ->limit($num)
            ->orderby('updated_at', 'desc')
            ->get();
    }

    public function moreArticle($category_id, $page)
    {
        if ($category_id == 0) {
            return $this->article
                ->join('profile', 'profile.user_id', 'article.user_id')
                ->select('profile.avatar', 'profile.real_name', 'article.*')
                ->where('attribute', '<>', 2)
                ->skip(config('site.index_page') + ($page-1)*config('site.more_article'))
                ->limit(config('site.more_article'))
                ->orderby('article.updated_at', 'desc')
                ->get();
        }

        return $this->article
            ->join('profile', 'profile.user_id', 'article.user_id')
            ->select('profile.avatar', 'profile.real_name', 'article.*')
            ->where('attribute', '<>', 2)
            ->where('category_id', $category_id)
            ->skip(config('site.index_page') + ($page-1)*config('site.more_article'))
            ->limit(config('site.more_article'))
            ->orderby('article.updated_at', 'desc')
            ->get();

    }

    public function article_rand($category_id, $num)
    {
        return $this->article
            ->where('attribute', '<>', 2)
            ->where('category_id', $category_id)
            ->limit($num)
            ->inRandomOrder()
            ->get();
    }

    public function generateGetAll(...$select)
    {
        return $this->article
            ->where('attribute', '<>', 2)
            ->select($select)
            ->get();
    }
}
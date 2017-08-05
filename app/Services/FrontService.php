<?php

namespace App\Services;

use App\Article;
use App\Comment;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRespository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class FrontService
{
    protected $article;
    protected $user;
    protected $comment;

    public function __construct(ArticleRepository $article, UserRepository $user, CommentRespository $comment)
    {
        $this->article = $article;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * 返回限定条数文章（不限制栏目）
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

    /**
     * 返回限定条数文章（指定栏目）
     * 按照article_id倒序排列
     *
     * @param $num
     * @return mixed
     */
    public function getArticleLimitDescCategory($category_id, $num)
    {
        return $this->article->getArticleLimitDescCategory($category_id, $num);
    }

    /**
     * 返回限定条数的置顶文章（指定栏目）
     * 按照article_id倒序排列
     *
     * @param $num
     * @return mixed
     */
    public function getArticleTopDescCategory($category_id, $num)
    {
        return $this->article->getArticleTopDescCategory($category_id, $num);
    }

    /**
     * 查找单条文章
     * 权限判断
     *
     * @param $article_id
     * @return mixed
     */
    public function findOneAndCategoryUser($article_id)
    {
        //权限验证
        if (!can('update', $this->article->find($article_id))) {
            throw new \Exception('不是您发布的文章！（错误代码：1005）');
        }

        //获取文章
        $article = $this->article->findOneAndCategoryUser('article_id', $article_id);

        //判断文章是否存在
        if (empty($article)) {
            throw new \Exception('找不到文章!');
        }

        return $article;
    }

    /**
     * 随机获取文章
     *
     * @param $category_id
     * @param $num
     * @return mixed
     */
    public function article_rand($category_id, $num)
    {
        return $this->article->article_rand($category_id, $num);
    }

    /**
     * 获取我的信息
     *
     * @param $user_id
     * @return mixed
     */
    public function me($user_id)
    {
        return $this->user->findAndProfile($user_id);
    }

    /**
     * 文章点击数加1
     *
     * @param $article_id
     * @return mixed
     */
    public function clickAdd($article_id)
    {
        $article = Article::find($article_id);
        $article->timestamps = false;
        $article->increment('click');

        return Article::select('click')->where('article_id', $article_id)->first()['click'];
    }

    public function comment($article_id, $data)
    {
        //获取文章信息
        $article = $this->article->findOne('article_id', $article_id, 'attribute');

        //判断是否为私密文章
        if ($article['attribute'] == 2) {
            //私密文件处理
            if (!$this->isAttribute($article)) {
                throw new \Exception('您无法评论本篇文章!（错误代码：1005）');
            }
        }

        //判断用户评论是否超过限制
        if ($this->comment->userShow() >= config('site.comment_article_limit')) {
            return [false, '评论数超过'.config('site.comment_article_limit').'条了！'];
        }

        //构建插入数据库数组
        $value['user_id'] = Auth::id();
        $value['article_id'] = $article_id;
        $value['content'] = $data['content'];
        $value['user_ip'] = ip2long($_SERVER['REMOTE_ADDR']);

        //写入数据库
        $result = Comment::create($value);

        if (!empty($result)) {
            return [true, '评论成功！'];
        }

        return [false, '评论失败！'];
    }

    /**
     * 判断当前权限私密文章是否有操作权限
     *
     * @param $article
     * @return mixed
     * @throws \Exception
     */
    public function isAttribute($article)
    {
        if ($article['user_id'] == Auth::id()) {
            return $article;
        }

        return false;
    }
}
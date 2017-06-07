<?php

namespace App\Service;

use App\Comment;
use App\Repositories\ArticleRepositories;
use App\Facades\Verfication;
use App\Repositories\CommentRespositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentService
{
    protected $comment;
    protected $request;
    protected $category;
    protected $generate;

    public function __construct(CommentRespositories $comment, Request $request, CategoryService $category, GenerateService $generate)
    {
        $this->comment = $comment;
        $this->request = $request;
        $this->category = $category;
        $this->generate = $generate;
    }

    /**
     * 判断是否是管理员
     *
     * @return bool
     */
    public function isAdmin()
    {
        try{
            Verfication::admin(Comment::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 验证用户是否可以操作本条评论
     * 验证失败抛错误
     *
     * @param $task_id
     * @return mixed
     */
    public function verfication($comment_id)
    {
        return Verfication::update($this->comment->findOne('comment_id', $comment_id));
    }

    /**
     * 获取评论列表
     * 根据权限执行不同操作
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function show($page, $num)
    {
        if (!$this->isAdmin()) {
            return $this->userShow($page, $num);
        }

        return $this->adminShow($page, $num);
    }

    /**
     * 普通用户获取评论列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function userShow($page, $num)
    {
        return $this->comment
            ->findMulti('user_id', Auth::id(), $page, $num)
            ->toArray();
    }

    /**
     * 管理员获取评论列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function adminShow($page, $num)
    {
        return $task = $this->comment
            ->getAll($page, $num)
            ->toArray();
    }

    /**
     * 统计评论总数量
     * 权限不同执行不同操作
     *
     * @return mixed
     */
    public function count()
    {
        if (!$this->isAdmin()) {
            return $this->comment->userCount(Auth::id());
        }

        return $this->comment->adminCount();
    }

    /**
     * 设置置顶
     * 管理员权限验证
     *
     * @param $comment_id
     * @return mixed
     */
    public function mask($comment_id)
    {
        //更新数据
        $value['status'] = 2;

        //写入数据库
        return $this->comment->update($value, $comment_id);
    }

    /**
     * 删除评论
     * 需要通过权限验证
     * 验证失败抛403
     *
     * @param $comment_id
     */
    public function destroy($comment_id)
    {
        //验证权限
        if (!$this->verfication($comment_id)) {
            throw new \Exception('您没有权限访问（代码：1006）！', 403);
        }

        //权限验证通过
        $this->comment->destroy('comment_id', $comment_id);
    }
}

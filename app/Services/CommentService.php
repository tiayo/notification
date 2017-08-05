<?php

namespace App\Services;

use App\Repositories\CommentRespository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentService
{
    protected $comment;
    protected $request;
    protected $category;
    protected $generate;

    public function __construct(CommentRespository $comment, Request $request, CategoryService $category, GenerateService $generate)
    {
        $this->comment = $comment;
        $this->request = $request;
        $this->category = $category;
        $this->generate = $generate;
    }

    /**
     * 获取评论列表
     * 根据权限执行不同操作
     *
     * @param $page //当前页数
     * @param $num //每页条数
     * @return mixed
     */
    public function show($page, $num)
    {
        if (!can('admin')) {
            return $this->userShow($page, $num);
        }

        return $this->adminShow($page, $num);
    }

    /**
     * 普通用户获取评论列表
     *
     * @param $page //当前页数
     * @param $num //每页条数
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
     * @param $page //当前页数
     * @param $num /每页条数
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
        if (!can('admin')) {
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
    public function mask($comment_id, $status)
    {
        //判断状态
        if ($status != 1 && $status != 2) {
            throw new \Exception('数据验证失败！（代码：1006）');
        }

        //更新数据
        $value['status'] = $status;

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
        if (!can('update', $this->comment->findOne('comment_id', $comment_id))) {
            throw new \Exception('您没有权限访问（代码：1006）！', 403);
        }

        //权限验证通过
        $this->comment->destroy('comment_id', $comment_id);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentService $comment)
    {
        $this->comment = $comment;
    }

    /**
     * 列表显示
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page)
    {
        //所有评论
        $list_comment = $this->comment->show($page, Config('site.page'));

        //文章数量
        $count = $this->comment->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = can('admin');

        return view('home.comment_list',[
            'list_comment' => $list_comment,
            'comment' => Comment::class,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'admin' => $admin,
            'judge' => 'App\Http\Controllers\Controller',
        ]);
    }

    /**
     * 屏蔽评论
     * 管理员操作
     * 非管理员抛403错误
     *
     * @param $comment_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function mask($comment_id, $status)
    {
        //错误抛错
        try{
            $this->comment->mask($comment_id, $status);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode()) ? 403 : $e->getCode());
        }

        //成功跳转
        return redirect()->route('comment_page', ['page' => 1]);
    }

    /**
     *  删除列表
     *  有权限认证，没有权限抛403
     *  插入错误抛相应错误和错误代码，默认403
     *
     * @param  int  $article_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        try {
            $this->comment->destroy($comment_id);
        } catch (\Exception $e) {
            return response($e->getMessage(), empty($e->getCode())? 403 : $e->getCode());
        }

        return redirect()->route('comment_page', ['page' => 1]);
    }
}
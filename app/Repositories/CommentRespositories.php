<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentRespositories
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function allCommentAndProfile($article_id)
    {
        return $this->comment
            ->leftJoin('profile', 'comment.user_id', '=', 'profile.user_id')
            ->select('comment.*', 'profile.real_name')
            ->where('comment.article_id', $article_id)
            ->where('comment.status', 1)
            ->orderby('comment.updated_at', 'desc')
            ->get();
    }

    public function userShow()
    {
        return $this->comment
            ->where('user_id', Auth::id())
            ->count();
    }

    public function getAll($page, $num)
    {
        return $this->comment
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('comment.updated_at', 'desc')
            ->get();
    }

    public function findMulti($option, $value, $page, $num)
    {
        return $this->comment
            ->skip(($page-1)*$num)
            ->take($num)
            ->where($option, $value)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->comment
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function adminCount()
    {
        return $this->comment->count();
    }

    public function userCount($user_id)
    {
        return $this->comment
            ->where('user_id', $user_id)
            ->count();
    }

    public function update($value, $comment_id)
    {
        return $this->comment
            ->where('comment_id', $comment_id)
            ->update($value);
    }

    public function destroy($option, $value)
    {
        return $this->comment
            ->where($option, $value)
            ->delete();
    }
}
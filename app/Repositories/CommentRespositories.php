<?php

namespace App\Repositories;

use App\Comment;

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
            ->get();
    }
}
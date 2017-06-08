<?php

namespace App\Repositories;

use App\Message;
use Illuminate\Support\Facades\Auth;

class messageRespositories
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function allmessageAndProfile($article_id)
    {
        return $this->message
            ->leftJoin('profile', 'message.user_id', '=', 'profile.user_id')
            ->select('message.*', 'profile.real_name')
            ->where('message.article_id', $article_id)
            ->where('message.status', 1)
            ->orderby('message.updated_at', 'desc')
            ->get();
    }

    public function userShow()
    {
        return $this->message
            ->where('user_id', Auth::id())
            ->count();
    }

    public function getAll($page, $num)
    {
        return $this->message
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('message.updated_at', 'desc')
            ->get();
    }

    public function findMulti($option, $value, $page, $num)
    {
        return $this->message
            ->skip(($page-1)*$num)
            ->take($num)
            ->where($option, $value)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->message
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function adminCount()
    {
        return $this->message->count();
    }

    public function userCount($user_id)
    {
        return $this->message
            ->where('user_id', $user_id)
            ->count();
    }

    public function update($value, $message_id)
    {
        return $this->message
            ->where('message_id', $message_id)
            ->update($value);
    }

    public function destroy($option, $value)
    {
        return $this->message
            ->where($option, $value)
            ->delete();
    }
}
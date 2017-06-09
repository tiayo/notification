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

    public function userShow()
    {
        return $this->message
            ->where('user_id', Auth::id())
            ->where('status', '<>', '2')
            ->count();
    }

    public function getAll($page, $num)
    {
        return $this->message
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('message.message_id', 'desc')
            ->get();
    }

    public function findMulti($page, $num)
    {
        return $this->message
            ->skip(($page-1)*$num)
            ->take($num)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', '<>', '3');
            })
            ->orwhere(function ($query) {
                $query->where('target_id', Auth::id())
                    ->where('status', '<>', '3');
            })
            ->orderBy('message_id', 'desc')
            ->get();
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->message
            ->select($data)
            ->where($option, $value)
            ->where('status', '<>', '2')
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
            ->where('status', '<>', '2')
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
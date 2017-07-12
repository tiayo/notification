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
            ->join('profile', 'message.user_id', '=', 'profile.user_id')
            ->select('message.*', 'profile.real_name', 'profile.avatar')
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('message.message_id', 'desc')
            ->get();
    }

    public function findMulti($page, $num)
    {
        return $this->message
            ->join('profile', 'message.user_id', '=', 'profile.user_id')
            ->select('message.*', 'profile.real_name', 'profile.avatar')
            ->skip(($page-1)*$num)
            ->take($num)
            ->where('message.target_id', Auth::id())
            ->where('message.status', '<>', '3')
            ->where('message.status', '<>', '4')
            ->orderBy('message.message_id', 'desc')
            ->get();
    }

    public function listMessageSend($page, $num)
    {
        return $this->message
            ->skip(($page-1)*$num)
            ->take($num)
            ->where('message.user_id', Auth::id())
            ->where('message.status', '<>', '4')
            ->orderBy('message.message_id', 'desc')
            ->get();
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->message
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function adminCount($option)
    {
        if ($option == 'received') {
            return $this->message->count();
        } elseif ($option == 'send') {
            return $this->message
                ->where($option, Auth::id())
                ->count();
        }
    }


    public function userCount($option, $id)
    {
        return $this->message
            ->where($option, $id)
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

    public function targetNoRead($target_id)
    {
        return $this->message
            ->where('user_id', Auth::id())
            ->where('target_id', $target_id)
            ->where('status', '1')
            ->count();
    }

    public function meNoRead()
    {
        return $this->message
            ->where('target_id', Auth::id())
            ->where('status', '1')
            ->count();
    }
}
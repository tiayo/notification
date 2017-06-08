<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Message;
use App\Service\IndexService;
use App\Service\MessageService;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageService $message)
    {
        $this->message = $message;
    }

    public function index($page)
    {
        //所有消息
        $list_message = $this->message->show($page, Config('site.page'));

        //文章数量
        $count = $this->message->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = IndexService::admin();

        return view('home.message_list',[
            'list_message' => $list_message,
            'message' => Message::class,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'admin' => $admin,
            'judge' => 'App\Http\Controllers\Controller',
        ]);
    }
}
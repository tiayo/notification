<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Message;
use App\Profile;
use App\Service\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    protected $message;
    protected $request;

    public function __construct(MessageService $message, Request $request)
    {
        $this->message = $message;
        $this->request = $request;
    }

    public function indexReceived($page)
    {
        //所有发出的消息
        $list_message = $this->message->received($page, Config('site.page'));

        //消息数量
        $count = $this->message->count('target_id');

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = can('admin');

        return view('home.message_list',[
            'list_message' => $list_message,
            'message' => Message::class,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'admin' => $admin,
            'judge' => 'App\Http\Controllers\Controller',
            'type' => '收到的消息',
        ]);
    }

    public function indexSend($page)
    {
        //所有发出的消息
        $list_message = $this->message->listMessageSend($page, Config('site.page'));

        //消息数量
        $count = $this->message->count('user_id');

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = can('admin');

        return view('home.message_list',[
            'list_message' => $list_message,
            'message' => Message::class,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'admin' => $admin,
            'judge' => 'App\Http\Controllers\Controller',
            'type' => '发出的消息',
        ]);
    }

    public function sendView($target_id)
    {
        //判断
        try{
            $this->message->sendView($target_id);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage());
        }

        return view('home.message_send', [
            'target' => Profile::where('user_id', $target_id)->first(),
            'old_input' => $this->request->session()->get('_old_input'),
        ]);
    }

    public function send($target_id)
    {
        $data = $this->request->all();

        try{
            $this->message->send($data, $target_id);
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('message_send_page', ['page' => 1]);
    }

    public function read($message_id, $status)
    {
        //业务执行
        try{
            $this->message->read($message_id, $status);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('message_received_page', ['page' => 1]);
    }

    public function destroy($message_id)
    {
        //业务执行
        try{
            $this->message->destroy($message_id);
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors($e->getMessage());
        }

        return Redirect::back()->withInput()->withErrors(null);
    }
}
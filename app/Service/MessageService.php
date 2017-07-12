<?php

namespace App\Service;

use App\Message;
use App\Facades\Verfication;
use App\Repositories\MessageRespositories;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Throw_;


class MessageService
{
    protected $message;
    protected $request;

    public function __construct(MessageRespositories $message, Request $request)
    {
        $this->message = $message;
        $this->request = $request;
    }

    /**
     * 验证用户是否可以操作本条评论
     * 验证失败抛错误
     *
     * @param $task_id
     * @return mixed
     */
    public function verfication($message_id)
    {
        return Verfication::message($this->message->findOne('message_id', $message_id));
    }

    /**
     * 获取收到的消息列表
     * 根据权限执行不同操作
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function received($page, $num)
    {
        return $this->message
            ->findMulti($page, $num)
            ->toArray();
    }

    /**
     * 获取发出的消息列表
     * 根据权限执行不同操作
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function listMessageSend($page, $num)
    {
        return $this->message
            ->listMessageSend($page, $num)
            ->toArray();
    }

    /**
     * 统计消息总数量
     * 权限不同执行不同操作
     *
     * @return mixed
     */
    public function count($option)
    {
        if (!can('admin')) {
            return $this->message->userCount($option, Auth::id());
        }

        return $this->message->adminCount($option);
    }


    public function send($data, $target_id)
    {
        //对方有三条信息未读时不能再发送
        if ($this->message->targetNoRead($target_id) >= 3) {
            throw new \Exception('对方还没有读您的消息，请等待！', 403);
        }

        //构建插入数据库数组
        $value['user_id'] = Auth::id();
        $value['target_id'] = $target_id;
        $value['content'] = $data['content'];
        $value['user_ip'] = ip2long($_SERVER['REMOTE_ADDR']);

        //插入数据库
        return Message::create($value);
    }

    /**
     * 设置状态
     * 操作权限验证
     *
     * @param $Message_id
     * @return mixed
     */
    public function read($message_id, $status)
    {
        //权限验证
        if (!can('message', $this->message->findOne('message_id', $message_id))) {
            throw new \Exception('您没有权限访问（代码：1007）！', 403);
        }

        //判断状态
        if ($status != 1 && $status != 2) {
            throw new \Exception('数据验证失败！（代码：1007）');
        }

        //更新数据
        $value['status'] = $status;

        //写入数据库
        return $this->message->update($value, $message_id);
    }

    /**
     * 删除消息
     * 需要通过权限验证
     * 没有实际删除（将状态设为2，即删除状态）
     *
     * @param $Message_id
     */
    public function destroy($message_id)
    {
        //验证权限
        if (!can('message', $this->message->findOne('message_id', $message_id))) {
            throw new \Exception('您没有权限访问（代码：1007）！', 403);
        }

        //权限验证通过
        $value['status'] = 3;

        //写入数据库
        return $this->message->update($value, $message_id);
    }

    public function meNoRead()
    {
        return $this->message->meNoRead();
    }

    public function sendView($target_id)
    {
        //查询用户是否存在
        if (empty(User::find($target_id)))
        {
            throw new \Exception('用户不存在！');
        }

        //不允许给自己发消息
        if (Auth::id() == $target_id) {
            throw new \Exception('不能给自己发送消息！', 403);
        }

        return true;
    }
}

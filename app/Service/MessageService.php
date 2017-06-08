<?php

namespace App\Service;

use App\Message;
use App\Facades\Verfication;
use App\Repositories\MessageRespositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageService
{
    protected $Message;
    protected $request;
    protected $category;
    protected $generate;

    public function __construct(MessageRespositories $Message, Request $request, CategoryService $category, GenerateService $generate)
    {
        $this->Message = $Message;
        $this->request = $request;
        $this->category = $category;
        $this->generate = $generate;
    }

    /**
     * 判断是否是管理员
     *
     * @return bool
     */
    public function isAdmin()
    {
        try{
            Verfication::admin(Message::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 验证用户是否可以操作本条评论
     * 验证失败抛错误
     *
     * @param $task_id
     * @return mixed
     */
    public function verfication($Message_id)
    {
        return Verfication::update($this->Message->findOne('Message_id', $Message_id));
    }

    /**
     * 获取评论列表
     * 根据权限执行不同操作
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function show($page, $num)
    {
        if (!$this->isAdmin()) {
            return $this->userShow($page, $num);
        }

        return $this->adminShow($page, $num);
    }

    /**
     * 普通用户获取评论列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function userShow($page, $num)
    {
        return $this->Message
            ->findMulti('user_id', Auth::id(), $page, $num)
            ->toArray();
    }

    /**
     * 管理员获取评论列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function adminShow($page, $num)
    {
        return $task = $this->Message
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
        if (!$this->isAdmin()) {
            return $this->Message->userCount(Auth::id());
        }

        return $this->Message->adminCount();
    }

    /**
     * 设置置顶
     * 管理员权限验证
     *
     * @param $Message_id
     * @return mixed
     */
    public function mask($Message_id)
    {
        //更新数据
        $value['status'] = 2;

        //写入数据库
        return $this->Message->update($value, $Message_id);
    }

    /**
     * 删除评论
     * 需要通过权限验证
     * 验证失败抛403
     *
     * @param $Message_id
     */
    public function destroy($Message_id)
    {
        //验证权限
        if (!$this->verfication($Message_id)) {
            throw new \Exception('您没有权限访问（代码：1006）！', 403);
        }

        //权限验证通过
        $this->Message->destroy('Message_id', $Message_id);
    }
}

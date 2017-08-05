<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class VerficationService
{

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * 权限验证失败抛403
     *
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public function admin($class)
    {
        if (!can('admin')) {
            throw new \Exception('拒绝访问！（代码：1001）', 403);
        }

        return true;
    }

    /**
     * 管理员跳过其他认证步骤
     *
     * @param $class
     * @return bool
     */
    public function skip()
    {
        if (!can('admin')) {
            return false;
        }

        return true;
    }

    /**
     * 任务更新操作权限认证
     *
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public function update($class)
    {
        if ($this->skip()) {
            return true;
        }

        if (!can('update', $class)) {
            return false;
        }

        return true;
    }

    /**
     *  消息操作权限认证
     *
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public function message($class)
    {
        if ($this->skip()) {
            return true;
        }

        if (!can('message', $class)) {
            return false;
        }

        return true;
    }

}

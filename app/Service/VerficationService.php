<?php

namespace App\Service;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;

class VerficationService
{

    protected $user;

    public function __construct(UserRepositories $user)
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
        if (!$this->user->find(Auth::id())->can('admin', $class)) {
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
    public function skip($class)
    {
        try{
            $this->admin($class);
        } catch (\Exception $e) {
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
        if ($this->skip(VerficationService::class)) {
            return true;
        }

        if (!$this->user->find(Auth::id())->can('update', $class)) {
            return false;
        }

        return true;
    }

}

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
        if (!$this->user->find(Auth::id())->can('admin', $class))
        {
            throw new \Exception('您没有权限访问（代码：admin）！', 403);
        }

        return true;
    }

    public function taskUpdate($class)
    {
        if (!$this->user->find(Auth::id())->can('update', $class))
        {
            throw new \Exception('您没有权限访问（代码：task update）！', 403);
        }

        return true;
    }

}

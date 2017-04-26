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
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public function admin($class)
    {
        if (!$this->user->find(Auth::id())->can('Admin', $class))
        {
            throw new \Exception('您没有权限访问！', 403);
        }

        return true;
    }

}

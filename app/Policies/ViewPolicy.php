<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 判断是否是管理员
     * 管理员返回true
     * 普通用户返回false
     * @param User $user
     * @return bool
     */
    public function admin(User $user)
    {
        return $user->name === config('site.adminstrator');
    }

    /**
     * 判断用户是否有修改权限
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user, $class)
    {
        return $user->id === $class['user_id'];
    }

}

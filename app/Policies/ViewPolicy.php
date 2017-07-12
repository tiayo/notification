<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ViewPolicy
{
    use HandlesAuthorization;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 判断是否是管理员
     *
     * @param User $user
     * @return bool
     */
    public function admin()
    {
        return Auth::user()['name'] === config('site.adminstrator');
    }

    /**
     * 判断用户是否有修改权限
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user, $class)
    {
        if ($this->admin()) {
            return true;
        }

        return Auth::id() === $class['user_id'];
    }

    /**
     * 判断用户是否有修改消息权限
     *
     * @param User $user
     * @return bool
     */
    public function message(User $user, $class)
    {
        if ($this->admin()) {
            return true;
        }

        return $user->id === $class['target_id'];
    }

}

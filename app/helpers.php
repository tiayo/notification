<?php

use App\Services\MailService;
use Illuminate\Support\Facades\Auth;

if (!function_exists('can')) {
    /**
     * 权限验证
     * 全局辅助函数
     *
     * @param $option
     * @param null $class
     * @param string $guard
     * @return mixed
     */
    function can($option, $class = null, $guard = '')
    {
        $user = Auth::guard($guard)->user();

        if (empty($user)) return false;

        $class = $class ?? $user;

        return $user->can($option, $class);
    }
}

if(!function_exists('MailSend')) {
    /**
     * 邮件发送方法
     * 使用方法详见MailController的test方法
     *
     * @param $user
     * @param $data

     */
    function MailSend($user, $data, $when = null)
    {
        MailService::email($user, $data, $when);
    }
}

<?php

namespace App\Services;

use App\Mail\PublicShipped;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * 测试邮件发送方法：
     *
     * 1、data->view : 模板存放到/resource/view/mails目录下，将目录赋值。
     *              例如mails/test.blade.php则赋值test；
     *              例如mails/register/test.blade.php则赋值register.test
     * 2、data->subject : 邮件标题,不设置邮件标题会被系统设为默认值
     * 3、data->assign ： 往邮件模板中的变量传值(若模板中有变量未传值将导致错误，该邮件发送将无法成功！)
     * 4、data->attach : 附件
     *
     */
    static public function test()
    {
        $data = [
            'view' => 'test',
            'subject' => '',
            'assign' => [],
            'attach' => base_path().'/public/images/logo.png'
        ];

        return MailSend(Auth::user(), $data);
    }

    /**
     * 邮件发送调度方法
     *
     * @param $user
     * @param $data
     */
    static public function email($user, $data)
    {
        return Mail::to($user)->send(new PublicShipped($data));
    }
}
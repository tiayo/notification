<?php

namespace App\Services;

use App\Mail\PublicShipped;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
     * 4、data->queue_name ： 推送到的队列，默认‘emails’
     * 5、data->attach : 附件
     *
     */
    static public function test()
    {
        $data = [
            'view' => 'test',
            'subject' => '',
            'assign' => [],
            'queue_name' => 'emails',
            'attach' => base_path().'/public/images/logo.png'
        ];

        $when = Carbon::now()->addSecond(0);

        return MailSend(Auth::user(), $data, $when);
    }

    /**
     * 邮件发送调度方法
     *
     * @param $user
     * @param $data
     */
    static public function email($user, $data, $when = null)
    {
        $when = empty($when) ? Carbon::now()->addSecond(0) : $when;

        Log::info('email service:', $data);

        return Mail::to($user)->later($when, new PublicShipped($data));
    }
}
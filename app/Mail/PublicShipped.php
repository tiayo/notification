<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PublicShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;

        //数据验证（抛错)
        $this->validata($data);
    }

    /**
     * 邮件发送主体
     *
     * @return $this
     */
    public function build()
    {
        Log::info('email build:', $this->data);

        if (isset($this->data['attach']) && !empty($this->data['attach'])) {
            return $this->view('mails.'.$this->data['view'], $this->data['assign'])
                ->subject($this->data['subject'])
                ->attach($this->data['attach']);
        }

        return $this->view('mails.'.$this->data['view'], $this->data['assign'])
            ->subject($this->data['subject']);
    }

    /**
     * 数据验证及给默认值
     *
     * @param $data
     * @throws \Exception
     */
    public function validata($data)
    {
        if (!isset($data['view']) || empty($data['view'])) {
            throw new \Exception('必须输入模板！');
        }

        if (!isset($data['subject']) || empty($data['subject'])) {
            $data['subject'] = null;
        }

        if (!isset($data['assign']) || empty($data['assign'])) {
            $data['assign'] = [];
        }

        if (!isset($data['attach']) || empty($data['attach'])) {
            $data['attach'] = null;
        }
    }
}

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

        //数据验证
        try {
            $this->validata($data);
        } catch (\Exception $e) {
            return $this->simpleRespose($e->getMessage());
        }

        // 加入指定队列
        $this->onQueue($data['queue_name']);
    }

    /**
     * 邮件发送主体
     *
     * @return $this
     */
    public function build()
    {
        Log::info('email build:', $this->data);

        if (empty($this->data['attach'])) {
            return $this->view('mails.'.$this->data['view'], $this->data['assign'])
                ->subject($this->data['subject']);
        }

        return $this->view('mails.'.$this->data['view'], $this->data['assign'])
            ->subject($this->data['subject'])
            ->attach($this->data['attach']);
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

        if (!isset($data['queue_name']) || empty($data['queue_name'])) {
            $data['queue_name'] = 'emails';
        }

        if (!isset($data['attach']) || empty($data['attach'])) {
            $data['attach'] = null;
        }
    }

    /**
     * 简单的错误返回
     *
     * @param $data
     * @param int $code
     * @return bool
     */
    public function simpleRespose($data, $code = 403)
    {
        echo (string) $data;

        http_response_code($code);

        exit();
    }
}

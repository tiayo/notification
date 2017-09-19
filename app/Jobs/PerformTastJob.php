<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Exception;

class PerformTastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        $site_title = config('site.title');

        $email = $this->task['email'];

        $data = [
            'view' => 'perform_task',
            'subject' => $this->task['title'].'-'.$site_title,
            'assign' => [
                'task' => $this->task,
                'plan' => 'App\Http\Controllers\Controller',
                'site_title' => $site_title,
            ],
        ];

        //发送邮件
        MailSend($email, $data);

        //记录到日志
        Log::info('Perform task success(email):', $this->task->toArray());
    }

    public function failed(Exception $exception)
    {
        $user = app('App\User')->where('name', config('site.adminstrator'))->first();

        $data = [
            'view' => 'failed',
            'subject' => '任务失败通知',
            'assign' => [
                'exception' => $exception,
            ],
        ];

        //发送邮件
        MailSend($user, $data);

        //记录到日志
        Log::info('Task add failed notice(email):', $exception);
    }
}

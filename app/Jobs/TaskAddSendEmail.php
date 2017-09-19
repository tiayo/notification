<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Exception;

class TaskAddSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    public function handle(User $user)
    {
        $user = $user->find($this->task->user_id);

        $data = [
            'view' => 'task_add',
            'subject' => '任务添加通知',
            'assign' => [
                'task' => $this->task,
                'plan' => 'App\Http\Controllers\Controller'
            ],
        ];

        //发送邮件
        MailSend($user, $data);

        //记录到日志
        Log::info('Task add success notice(email):', $this->task->toArray());
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

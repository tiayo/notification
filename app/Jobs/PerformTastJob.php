<?php

namespace App\Jobs;

use App\Task;
use App\User;
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
    protected $user;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
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
            'queue_name' => 'task_perform',
        ];

        //发送邮件
        MailSend($email, $data);

        //记录到日志
        Log::info('Perform task success(email):', $this->task->toArray());
    }

    public function failed(Exception $exception)
    {
        $user = $this->user->where('name', config('site.adminstrator'))->first();

        $data = [
            'view' => 'failed',
            'subject' => '任务失败通知',
            'assign' => [
                'exception' => $exception,
            ],
            'queue_name' => 'task_perform',
        ];

        //发送邮件
        MailSend($user, $data);

        //记录到日志
        Log::info('Task add failed notice(email):', $exception);
    }
}

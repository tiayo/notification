<?php

namespace App\Jobs;

use App\Task;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\MailService;
use Illuminate\Support\Facades\Log;

class PerformTastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle(MailService $mail)
    {
        $site_title = config('site.title');
        $template = 'emails.perform_task';
        $user_email = $this->task['email'];
        $name = $this->task['title'].'-'.$site_title;
        $data = [
            'task' => $this->task,
            'plan' => 'App\Http\Controllers\Controller',
            'site_title' => $site_title,
        ];

        //发送邮件
        $mail->mailSend($template, $user_email, $name, $data);

        //记录到日志
        Log::info('Perform task success(email):',$this->task->toArray());
    }
}

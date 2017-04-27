<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\MailService;
use Illuminate\Support\Facades\Auth;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $mail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, MailService $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    public function handle($task)
    {
        $template = 'emails.task_add';
        $user_email = Auth::user()->email;
        $name = '任务添加通知';
        $data = [
            'task' => $task,
            'plan' => 'App\Http\Controllers\Controller'
        ];

        $this->mail->mailSend($template, $user_email, $name, $data);
    }
}

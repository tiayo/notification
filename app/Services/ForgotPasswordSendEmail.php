<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordSendEmail extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('重置密码')
            ->line('您收到这封邮件是因为您发起了重置密码请求，如果您没有，请忽略本邮件。')
            ->action('重置密码', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('如果你不需要重置密码，您不用进一步操作！');
    }
}
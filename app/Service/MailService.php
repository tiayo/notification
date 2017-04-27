<?php

namespace App\Services;

use App\Mail\AddTask;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function mailSend($Template, $user_email, $name, $data = [])
    {
        Mail::to($user_email)->send(new AddTask($Template, $name, $data));
    }
}
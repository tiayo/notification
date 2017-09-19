<?php

namespace App\Listeners;

use App\Events\AddTaskEvent;
use App\Jobs\TaskAddSendEmail;
use Carbon\Carbon;

class AddTaskListener
{
    public function handle(AddTaskEvent $event)
    {
        $job = (new TaskAddSendEmail($event->task))->delay(Carbon::now()->addSecond(1));

        dispatch($job);
    }
}

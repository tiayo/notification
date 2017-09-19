<?php

namespace App\Listeners;

use App\Events\AddTaskEvent;
use App\Jobs\TaskAddSendEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddTaskListener implements ShouldQueue
{
    #public $queue = 'taskadd';

    public function handle(AddTaskEvent $event)
    {
        $job = (new TaskAddSendEmail($event->task))->delay(Carbon::now()->addSecond(1));

        dispatch($job);
    }
}

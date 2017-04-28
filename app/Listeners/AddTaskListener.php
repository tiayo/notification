<?php

namespace App\Listeners;

use App\Events\AddTask;
use App\Jobs\TaskAddSendEmail;
use Carbon\Carbon;

class AddTaskListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(AddTask $event)
    {
        $job = (new TaskAddSendEmail($event->task))->delay(Carbon::now()->addSecond(1));
        dispatch($job);
    }
}

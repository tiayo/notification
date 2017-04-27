<?php

namespace App\Listeners;

use App\Events\AddTask;
use App\Jobs\SendReminderEmail;
use Carbon\Carbon;

class AddTaskListener
{

    protected $event;
    protected $send;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AddTask $event, SendReminderEmail $send)
    {
        $this->event = $event;
        $this->send = $send;
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle()
    {
        $job = ($this->send->handle($this->event->tack))->delay(Carbon::now()->addSecond(10));
        dispatch($job);
    }
}

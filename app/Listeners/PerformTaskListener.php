<?php

namespace App\Listeners;

use App\Events\PerformTaskEvent;
use App\Jobs\PerformTastJob;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PerformTaskListener
{
    public function handle(PerformTaskEvent $event, User $user)
    {
        $time_difference = strtotime($event->task['start_time']) - strtotime(Carbon::now());

        Log::info('task data:'.$event->task);

        Log::info('diff time:'.$time_difference);

        $job = (new PerformTastJob($event->task, $user))->delay(Carbon::now()->addSecond($time_difference));

        dispatch($job);
    }
}

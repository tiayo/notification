<?php

namespace App\Service;

use App\Events\PerformTaskEvent;
use App\Repositories\CategoryRepositories;
use App\Repositories\TaskRepositories;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Log;

class TaskCheckService
{
    protected $task;
    protected $category;

    public function __construct(TaskRepositories $task, CategoryRepositories $category)
    {
        $this->task = $task;
        $this->category = $category;
    }

    /**
     * 分批获取任务传到handle方法处理
     *
     */
    public function screenTask()
    {
        Log::info('check task:'.Carbon::now());
        //全站任务总数
        $task_num = $this->task->adminCount();

        //一次查询数量
        $serch_num = config('site.screen_task');

        // 循环次数
        $num = ceil($task_num/$serch_num);

        for ($i=1; $i<=$num; $i++) {
            $data = $this->task->findTastCheck($i, $serch_num);
            if (!empty($data)) {
                $this->handle($data);
            }
        }
    }

    public function handle($data)
    {
        foreach ($data as $item) {
            switch ($item['plan']) {
                case 1:
                    return $this->singleTask($item);
                case 2:
                    return $this->dailyTask($item);
                case 3:
                    return $this->workTask($item);
            }
        }
    }

    public function singleTask($item)
    {
        if (Carbon::now() <= $item['start_time']) {
            $time_difference = strtotime($item['start_time']) - strtotime(Carbon::now());
            $item['time_difference'] = $time_difference;
            event(new PerformTaskEvent($item));
            $value = ['status' => 0];
            $this->task->update($value, $item['task_id']);
        }
        return true;
    }

    public function dailyTask($item)
    {

    }

    public function workTask($item)
    {

    }
}














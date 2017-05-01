<?php

namespace App\Service;

use App\Events\PerformTaskEvent;
use App\Repositories\CategoryRepositories;
use App\Repositories\TaskRepositories;
use Carbon\Carbon;
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
        //全站任务总数
        $task_num = $this->task->adminCount();

        //一次查询数量
        $serch_num = config('site.screen_task');

        // 循环次数
        $num = ceil($task_num/$serch_num);

        //初始化
        $data = null;

        for ($i=1; $i<=$num; $i++) {
            $data = $this->task->findTastCheck($i, $serch_num);
            Log::info('event data:'.json_encode($data));
            if (!empty($data)) {
                $this->handle($data);
            }
            continue;
        }
        Log::info('check task end:'.Carbon::now());
    }

    public function handle($data)
    {
        foreach ($data as $item) {
            switch ($item['plan']) {
                case 1:
                    $this->singleTask($item);
                    break;
                case 2:
                    $this->dailyTask($item);
                    break;
                case 3:
                    $this->workTask($item);
                    break;
            }
        }
        return true;
    }

    public function singleTask($item)
    {
        if (Carbon::now() <= $item['start_time']) {
            $time_difference = strtotime($item['start_time']) - strtotime(Carbon::now());
            $item['time_difference'] = $time_difference;

            //设置状态为0防止重复
            $value = ['task_status' => 0];
            try{
                $this->task->update($value, $item['task_id']);
            } catch (\Exception $e) {

            }
            //触发事件
            event(new PerformTaskEvent($item));
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














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
        //新任务
        if ($item['task_status'] == 1) {
            //开始时间大于当前时间，加入队列
            if (Carbon::now() >= $item['start_time']) {
                $item['start_time'] = Carbon::now()->addMinute(2);
            }

            //修改状态防止重复定义任务
            $value = ['task_status' => $this->task->findOne('task_id', $item['task_id'], 'task_status')['task_status'] + 1];
            try{
                $this->task->update($value, $item['task_id']);
            } catch (\Exception $e) {

            }
            //触发事件
            event(new PerformTaskEvent($item));
        }

        //老任务
        if ($item['task_status'] > 1) {
            //情况一：定义的时间还大于当前
            if ($item['start_time'] >= Carbon::now()) {
                return false;
            }

            $time_difference = strtotime(Carbon::now()) - strtotime($item['start_time']);

            //情况二：生成任务时间小于整数天
            if ($time_difference < 120*$item['task_status']) {
                return false;
            }

            $item['start_time'] = $item['start_time'] = Carbon::now()->addMinute(2);
            //修改状态防止重复定义任务
            $value = ['task_status' => $this->task->findOne('task_id', $item['task_id'], 'task_status')['task_status'] + 1];
            try{
                $this->task->update($value, $item['task_id']);
            } catch (\Exception $e) {

            }
            //触发事件
            event(new PerformTaskEvent($item));
        }

    }

    public function workTask($item)
    {

    }
}














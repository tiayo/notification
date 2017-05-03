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
                    $this->workTaskOne($item);
                    break;
                case 4:
                    $this->workTaskTwo($item);
                    break;
            }
        }
        return true;
    }

    /**
     * 单次任务
     *
     * @param $item
     * @return bool
     */
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

    /**
     * 每日任务
     *
     * @param $item
     * @return bool
     */
    public function dailyTask($item)
    {
        //新任务
        if ($item['task_status'] == 1) {
            //当前时间大于开始时间，排到下一天执行
            if (Carbon::now() >= $item['start_time']) {
                //设置开始时间
                while ($item['start_time'] < Carbon::now()) {
                    $item['start_time'] = Carbon::parse($item['start_time'])->addDay(1);
                }
            }

            //更新提醒时间
            $this->task->update(['start_time' => $item['start_time']], $item['task_id']);

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

            //定义的时间还大于当前，不继续执行
            if ($item['start_time'] > Carbon::now()) {
                return false;
            }

            //设置开始时间
            $item['start_time'] = Carbon::parse($item['start_time'])->addDay(1);

            //更新提醒时间
            $this->task->update(['start_time' => $item['start_time']], $item['task_id']);

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

    /**
     * 工作日（周一到周五）任务
     *
     * @param $item
     */
    public function workTaskOne($item)
    {
        while (true) {
            if ($this->isWeekend($item['start_time'])) {
                break;
            }
            $item['start_time'] = Carbon::parse($item['start_time'])->addDay(1);
        }

        $this->dailyTask($item);
    }

    /**
     * 工作日（周一到周六）任务
     *
     * @param $item
     */
    public function workTaskTwo($item)
    {
        while (true) {
            if ($this->isSunday($item['start_time'])) {
                break;
            }
            $item['start_time'] = Carbon::parse($item['start_time'])->addDay(1);
        }

        $this->dailyTask($item);
    }

    /**
     * 判断是否为工作日（周一到周五）
     *
     * @param $time
     */
    public function isWeekend($time)
    {
        if (Carbon::parse($time)->isWeekend()) {
            return false;
        }
        return true;
    }

    /**
     * 判断是否为周日
     *
     * @param $time
     * @return bool
     */
    public function isSunday($time)
    {
        if (Carbon::parse($time)->isSunday()) {
            return false;
        }
        return true;
    }
}














<?php

namespace App\Repositories;

use App\Task;

class TaskRepositories
{
    protected $task;

    function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getAll($page, $num)
    {
        return $this->task
            ->leftJoin('category', 'task.category', '=', 'category.category_id')
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('task.task_id', 'desc')
            ->get();
    }

    public function getWhere($value = '*', $page, $num)
    {
        return $this->task
            ->select($value)
            ->skip(($page-1) * $num)
            ->take($num)
            ->orderBy('task.task_id', 'desc')
            ->get();
    }

    public function findMulti($option, $value, $page, $num)
    {
        return $this->task
            ->join('category', 'task.category', '=', 'category.category_id')
            ->skip(($page-1)*$num)
            ->take($num)
            ->where($option, $value)
            ->orderBy('task.task_id', 'desc')
            ->get();
    }

    public function findTaskCheck($page, $num)
    {
        return $this->task
            ->where('task_status', '<>', 0)
            ->skip(($page-1)*$num)
            ->take($num)
            ->get();
    }

    public function findOne($option, $value, $data = '*')
    {
        return $this->task
            ->select($data)
            ->where($option, $value)
            ->first();
    }

    public function store($value)
    {
        return $this->task
            ->create($value);
    }

    public function update($value, $task_id)
    {
        return $this->task
            ->where('task_id', $task_id)
            ->update($value);
    }

    public function adminCount()
    {
        return $this->task->count();
    }

    public function userCount($user_id)
    {
        return $this->task
            ->where('user_id', $user_id)
            ->count();
    }

    public function destroy($option, $value)
    {
        return $this->task
            ->where($option, $value)
            ->delete();
    }

}
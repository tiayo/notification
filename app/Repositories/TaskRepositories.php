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
            ->skip(($page-1)*$num)
            ->take($num)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function findMulti($option, $value, $page, $num)
    {
        return $this->task
            ->skip(($page-1)*$num)
            ->take($num)
            ->where($option, $value)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function findOne($option, $value)
    {
        return $this->task
            ->where($option, $value)
            ->first();
    }

    public function store($value)
    {
        return $this->task
            ->create($value);
    }

    public function update($value)
    {
        return $this->task
            ->update($value);
    }

    public function adminCount()
    {
        return $this->task->count();
    }

    public function userCount($user_id)
    {
        return $this->task
            ->where('id', $user_id)
            ->count();
    }

}
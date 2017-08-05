<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Repositories\UserRepository $user)
    {
        //清除表
        App\Task::truncate();

        factory(App\Task::class)->create([
            'category' => 2,
            'title' => 'admin任务',
            'user_id' => $user->selectFirst('id', 'name', 'admin')['id'],
            'start_time' => \Carbon\Carbon::now(),
            'plan' => 1,
            'email' => '656861622@qq.com',
            'phone' => '13959823003',
            'content' => '测试任务'
        ]);

        factory(App\Task::class)->create([
            'category' => 2,
            'title' => 'tiayo任务',
            'user_id' => $user->selectFirst('id', 'name', 'tiayo')['id'],
            'start_time' => \Carbon\Carbon::now(),
            'plan' => 2,
            'email' => '474993693@qq.com',
            'phone' => '13959823003',
            'content' => '测试任务'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除表
        App\User::truncate();

        factory(App\User::class)->create([
            'name' => 'admin',
            'email' => '656861622@qq.com',
            'password' => bcrypt('474993693'),
        ]);

        factory(App\User::class)->create([
            'name' => 'tiayo',
            'email' => '474993693@qq.com',
            'password' => bcrypt('474993693'),
        ]);
    }
}

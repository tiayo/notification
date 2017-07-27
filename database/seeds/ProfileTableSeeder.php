<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除表
        App\Profile::truncate();

        $users = App\User::all();

        foreach ($users as $user) {
            factory(App\Profile::class)->create([
                'user_id' => $user->id,
                'real_name' => $user->name,
                'avatar' => '/images/user.jpg'
            ]);
        }
    }
}

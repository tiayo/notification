<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Repositories\CategoryRepository $category)
    {
        //清除表
        App\Category::truncate();

        factory(\App\Category::class)->create([
            'name' => '文章',
            'parent_id' => '0',
            'alias' => 'article',
        ]);

        factory(\App\Category::class)->create([
            'name' => '我的任务',
            'parent_id' => '0',
            'alias' => 'task',
        ]);

        factory(\App\Category::class)->create([
            'name' => '我的文章',
            'parent_id' => $category->selectWhereFirst('category_id', 'alias', 'article')['category_id'],
            'alias' => 'task',
        ]);

        factory(\App\Category::class)->create([
            'name' => '我的任务',
            'parent_id' => $category->selectWhereFirst('category_id', 'alias', 'task')['category_id'],
            'alias' => 'task',
        ]);
    }
}

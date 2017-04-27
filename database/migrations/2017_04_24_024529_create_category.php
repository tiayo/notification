<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Category;

class CreateCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('name', 50);
            $table->string('alias', 50);
            $table->integer('parent_id');
            $table->timestamps();
        });

        $category = new Category;
        $category->create([
            'name' => '默认',
            'parent_id' => '0',
            'alias' => 'default',
        ]);
        $category->create([
            'name' => '闹钟任务',
            'parent_id' => '1',
            'alias' => 'alarm',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('article_id');
            $table->integer('category');
            $table->string('attribute')->default(1);
            $table->string('title')->unique();
            $table->string('abstract');
            $table->string('picture')->nullable();
            $table->string('type')->nullable();
            $table->string('links')->nullable();
            $table->string('place')->nullable();
            $table->integer('user_id');
            $table->bigInteger('user_ip');
            $table->longText('body');
            $table->integer('click')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}

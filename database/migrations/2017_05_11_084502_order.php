<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->integer('user_id');
            $table->integer('product_id')->nullable();
            $table->text('title');
            $table->longText('content');
            $table->float('total_amount', 8, 2);
            $table->integer('order_status')->default('1');
            $table->text('payment_type')->nullable();
            $table->integer('payment_status')->default('0');
            $table->text('trade_no')->nullable();
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
        Schema::dropIfExists('order');
    }
}

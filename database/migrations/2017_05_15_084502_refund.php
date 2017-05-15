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
        Schema::create('refund', function (Blueprint $table) {
            $table->bigIncrements('refund_id');
            $table->bigInteger('refund_number');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('order_number');
            $table->bigInteger('trade_no');
            $table->float('refund_amount', 8, 2);
            $table->text('refund_reason');
            $table->text('payment_type');
            $table->integer('refund_status');
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
        Schema::dropIfExists('refund');
    }
}

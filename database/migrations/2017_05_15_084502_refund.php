<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Refund extends Migration
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
            $table->text('refund_number');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->text('order_number');
            $table->text('order_title');
            $table->text('product_id')->nullable();
            $table->text('trade_no');
            $table->float('refund_amount', 8, 2);
            $table->text('refund_reason');
            $table->text('reply')->nullable();
            $table->text('payment_type');
            $table->integer('refund_status')->default(2);
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

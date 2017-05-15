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
            $table->double('refund_number', 50, 0);
            $table->integer('user_id');
            $table->integer('order_id');
            $table->double('order_number', 50, 0);
            $table->double('trade_no', 50, 0);
            $table->float('refund_amount', 8, 2);
            $table->text('refund_reason');
            $table->text('payment_type');
            $table->integer('refund_status')->default(3);
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

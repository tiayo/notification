<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'refund_id',
        'user_id',
        'order_id',
        'order_number',
        'trade_no',
        'refund_amount',
        'refund_reason',
        'payment_type',
        'refund_status',
        'refund_number',
        'order_title',
        'product_id'
    ];
    protected $connection = 'mysql';
    protected $table = 'refund';
    protected $primaryKey = 'refund_id';

}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'order_number',
    	'user_id',
    	'product_id',
        'title',
        'content',
        'status',
        'total_amount',
    ];
    protected $connection = 'mysql';
    protected $table = 'order';
    protected $primaryKey = 'order_id';

}


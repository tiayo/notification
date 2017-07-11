<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    protected $fillable = [
        'user_id', 'title', 'type', 'money', 'location', 'remark', 'time'
    ];

    protected $primaryKey = 'accounting_id';
}

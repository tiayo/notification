<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'category',
        'user_id',
        'title',
        'start_time',
        'end_time',
        'plan',
        'email',
        'phone',
        'content',
        'task_status',
    ];
    protected $connection = 'mysql';
    protected $table = 'task';
    protected $primaryKey = 'task_id';

}


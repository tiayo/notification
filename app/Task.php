<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'category',
        'title',
        'start_time',
        'end_time',
        'email',
        'phone',
        'content',
    ];
    protected $connection = 'mysql';
    protected $table = 'task';
    protected $primaryKey = 'id';

}


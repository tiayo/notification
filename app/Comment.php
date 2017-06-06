<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'user_ip',
        'content',
        'article_id',
        'status',
    ];
    protected $connection = 'mysql';
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
}


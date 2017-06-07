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

    public function profile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id', 'article_id');
    }
}


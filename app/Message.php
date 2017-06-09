<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'target_id',
        'content',
        'status',
        'user_ip',
    ];
    protected $connection = 'mysql';
    protected $table = 'message';
    protected $primaryKey = 'message_id';

    public function userProfile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }

    public function targetProfile()
    {
        return $this->belongsTo('App\Profile', 'target_id', 'user_id');
    }

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id', 'article_id');
    }
}


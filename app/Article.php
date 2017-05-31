<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'article_id',
        'category',
        'attribute',
        'title',
        'abstract',
        'picture',
        'type',
        'condition',
        'place',
        'user_name',
        'user_id',
        'user_ip',
        'body',
        'click',
    ];
    protected $connection = 'mysql';
    protected $table = 'article';
    protected $primaryKey = 'article_id';

    public function profile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }
}


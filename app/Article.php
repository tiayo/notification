<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'article_id',
        'category_id',
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

    protected $connection = 'mysql2';

    protected $table = 'article';

    protected $primaryKey = 'article_id';

    public function profile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment', 'article_id', 'article_id');
    }
}
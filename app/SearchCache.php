<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchCache extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'content',
    ];
    protected $connection = 'mysql';
    protected $table = 'search_cache';
    protected $primaryKey = 'search_id';

}


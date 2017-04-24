<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'title',
        'parent_id',
    ];
    protected $connection = 'mysql';
    protected $table = 'category';
    protected $primaryKey = 'id';

}


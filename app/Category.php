<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;
    protected $fillable = [
    	'name',
    	'alias',
        'parent_id',
    ];
    protected $connection = 'mysql';
    protected $table = 'category';
    protected $primaryKey = 'category_id';

}


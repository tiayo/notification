<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'avatar',
        'phone',
        'real_name',
        'age',
        'state',
        'city',
        'address',
        'certified',
        'status',
    ];
    protected $connection = 'mysql';
    protected $table = 'profile';
    protected $primaryKey = 'profile_id';
}


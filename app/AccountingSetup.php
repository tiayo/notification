<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingSetup extends Model
{
    protected $fillable = [
        'user_id', 'budget', 'type', 'cycle'
    ];

    protected $primaryKey = 'accounting_setup_id';

    protected $table = 'accounting_setup';
}

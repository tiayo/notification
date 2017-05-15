<?php

namespace App\Repositories;

use App\Refund;
use Illuminate\Support\Facades\Auth;

class RefundRepositories
{
    protected $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }

    public function create($data)
    {
        return $this->refund
            ->create($data);
    }

}
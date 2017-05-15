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

    public function update($order_id, $value)
    {
        return $this->refund
            ->where('order_id', $order_id)
            ->update($value);
    }

    public function count($option, $value)
    {
        return $this->refund
            ->where($option, $value)
            ->count();
    }

    public function findOne($option, $value)
    {
        return $this->refund
            ->where($option, $value)
            ->first();
    }

}
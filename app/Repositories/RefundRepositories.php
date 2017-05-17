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

    public function update($option, $order_id, $value)
    {
        return $this->refund
            ->where($option, $order_id)
            ->update($value);
    }

    public function count($option, $value)
    {
        return $this->refund
            ->where($option, $value)
            ->count();
    }

    public function countNoWhere()
    {
        return $this->refund
            ->count();
    }

    public function findOne($option, $value)
    {
        return $this->refund
            ->where($option, $value)
            ->first();
    }

    public function get($page, $num)
    {
        return $this->refund
            ->skip(($page-1)*$num)
            ->take($num)
            ->orderBy('refund_id', 'desc')
            ->get();
    }

    public function findRefundAndUser($option, $value)
    {
        return $this->refund
            ->join('users', 'refund.user_id', '=', 'users.id')
            ->select('refund.*', 'users.name')
            ->where($option, $value)
            ->first();
    }

    public function findRefundAndOrder($option, $value)
    {
        return $this->refund
            ->join('order', 'refund.order_id', '=', 'order.order_id')
            ->select('refund.*', 'order.*')
            ->where($option, $value)
            ->first();
    }
}
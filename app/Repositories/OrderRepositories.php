<?php

namespace App\Repositories;

use App\Order;

class OrderRepositories
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function findOne($order_id)
    {
        return $this->order
            ->where('order_id', $order_id)
            ->first();
    }

    public function update($option, $value, $data)
    {
        return $this->order
            ->where($option, $value)
            ->update($data);
    }

    public function create($data)
    {
        return $this->order
            ->create($data);
    }

}
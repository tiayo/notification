<?php

namespace App\Repositories;

use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepositories
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function findOne($option, $value)
    {
        return $this->order
            ->where($option, $value)
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

    public function adminCount()
    {
        return $this->order->count();
    }

    public function userCount()
    {
        return $this->order
            ->where('user_id', Auth::id())
            ->count();
    }

    public function adminShow($page, $num)
    {
        return $this->order
            ->skip(($page-1)*$num)
            ->take($num)
            ->orderBy('order_id', 'desc')
            ->get();
    }

    public function userShow($page, $num)
    {
        return $this->order
            ->where('user_id', Auth::id())
            ->skip(($page-1)*$num)
            ->take($num)
            ->orderBy('order_id', 'desc')
            ->get();
    }
}
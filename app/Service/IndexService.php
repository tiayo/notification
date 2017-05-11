<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Auth;

class IndexService
{

    protected $verfication;
    protected $order;

    public function __construct(VerficationService $verfication, OrderRepositories $order)
    {
        $this->verfication = $verfication;
        $this->order = $order;
    }

    /**
     * 判断是否为管理
     * 管理员返回true
     * 非管理返回false
     *
     * @return bool
     */
    static public function admin()
    {
        try{
            Verfication::admin(IndexService::class);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sponsor($money)
    {
        $data = [
            'user_id' => Auth::id(),
            'title' => '赞助'.config('site.title'),
            'content' => '赞助'.config('site.title').$money.'块钱',
            'total_amount' => $money,
        ];

        return $this->order->create($data);
    }

}

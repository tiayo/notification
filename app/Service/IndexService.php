<?php

namespace App\Service;

use App\Facades\Verfication;

class IndexService
{

    protected $verfication;

    public function __construct(VerficationService $verfication)
    {
        $this->verfication = $verfication;
    }

    /**
     * 判断是否为管理
     * 管理员返回true
     * 非管理返回false
     *
     * @return bool
     */
    public function admin()
    {
        try{
            Verfication::admin(IndexService::class);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public static function plan($id)
    {
        switch ($id) {
            case 1 :
                return '单次';
                break;
            case 2 :
                return '每天';
                break;
            case 3 :
                return '工作日（周一到周五）';
                break;
            case 4 :
                return '工作日（周一到周六）';
                break;
            case 5 :
                return '工作日（跳过法定节假日）';
                break;
        }
    }

    public static function paymentStatus($num)
    {
        switch ($num) {
            case 0 :
                return '未付款';
                break;
            case 1 :
                return '付款成功';
                break;
        }
    }

    public static function paymentType($type)
    {
        switch ($type) {
            case 'alipay' :
                return '支付宝';
                break;
            case 'weixin' :
                return '微信支付';
                break;
            default :
                return '未付款';
        }
    }

    public static function orderStatus($num)
    {
        switch ($num) {
            case 0 :
                return '异常订单';
                break;
            case 1 :
                return '正常订单';
                break;
            case 2 :
                return '申请退款';
                break;
            case 3 :
                return '退款成功';
                break;
            case 4 :
                return '退款失败';
                break;
            case 5 :
                return '订单取消';
                break;
        }
    }

    public static function refundStatus($num)
    {
        switch ($num) {
            case 2 :
                return '申请退款';
                break;
            case 3 :
                return '退款成功';
                break;
            case 4 :
                return '退款失败';
                break;
            case 5 :
                return '退款被拒绝';
                break;
            default :
                return '退款异常';
                break;
        }
    }

    public static function articleStatus($num)
    {
        switch ($num) {
            case 1 :
                return '普通';
                break;
            case 2 :
                return '私密';
            case 3 :
                return '置顶';
                break;
        }
    }

    public static function StoreOrUpdate($str)
    {
        switch ($str) {
            case 'update' :
                return '更新';
                break;
            case 'store' :
                return '添加';
                break;
        }
    }
}
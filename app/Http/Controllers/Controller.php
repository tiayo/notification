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
            case 4 :
                return '头条';
                break;
        }
    }

    public static function isStoreOrUpdate($str)
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

    public function jsonResponse($message, $code = 200)
    {
        $hearder = array('Content-Type' => 'application/json; charset=utf-8');
        return response()->json($message, $code, $hearder, JSON_UNESCAPED_UNICODE);
    }

    public static function commentStatus($num)
    {
        switch ($num) {
            case 1 :
                return '正常';
                break;
            case 2 :
                return '屏蔽';
        }
    }

    public static function userCertified($num)
    {
        switch ($num) {
            case 0 :
                return '未实名认证';
                break;
            case 2 :
                return '实名认证用户';
        }
    }

    public static function messageStatus($num)
    {
        switch ($num) {
            case 1 :
                return '未读';
                break;
            case 2 :
                return '已读';
                break;
            case 3 :
                return '不在对方列表';
                break;
            case 4 :
                return '发送者删除';
                break;
        }
    }

    public static function accountingType($num)
    {
        switch ($num) {
            case 1 :
                return '饮食';
                break;
            case 2 :
                return '购物';
                break;
            case 3 :
                return '出行';
                break;
            case 4 :
                return '住宿';
                break;
            case 5 :
                return '娱乐';
                break;
            case 6 :
                return '医疗';
                break;
            case 7 :
                return '手机、宽带';
                break;
            case 0 :
                return '其他';
                break;
        }
    }

    public static function accountingSetupType($num)
    {
        switch ($num) {
            case 1 :
                return '月度';
                break;
            case 2 :
                return '年度';
                break;
            case 3 :
                return '单天';
                break;
            case 0 :
                return '自定义';
                break;
        }
    }
}
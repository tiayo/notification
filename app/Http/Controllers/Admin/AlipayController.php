<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Alipay\Wappay\Service\AlipayTradeService;
use App\Alipay\Wappay\Buildermodel\AlipayTradeWapPayContentBuilder;

class AlipayController extends Controller
{

    protected $request;
    protected $config;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function alipay()
    {
        return view('payment.alipay_pay');
    }

    public function alipayPay()
    {
        $post = $this->request->all();

        if (!empty($post['WIDout_trade_no'])&& trim($post['WIDout_trade_no'])!=""){
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $post['WIDout_trade_no'];

            //订单名称，必填
            $subject = $post['WIDsubject'];

            //付款金额，必填
            $total_amount = $post['WIDtotal_amount'];

            //商品描述，可空
            $body = $post['WIDbody'];

            //超时时间
            $timeout_express="1m";

            $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);

            $alipayTradeService = new AlipayTradeService();
            $alipayTradeService->wapPay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));

            return true;
        }
    }

    public function alipayCallback(Request $request)
    {
        $this->request->all();
    }

    public function alipayApp(Request $request)
    {
        Log::info('alipay:'.json_encode($request->all()));
    }
}

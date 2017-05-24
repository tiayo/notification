<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\PayPalAPI\GetTransactionDetailsReq;
use PayPal\PayPalAPI\GetTransactionDetailsRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\Config\Configuration;

class PayPalController extends Controller
{
    public function index()
    {
        return view('payment.paypal_query');
    }

    public function query(Request $request)
    {
        $transactionDetails = new GetTransactionDetailsRequestType();
        /*
         * Unique identifier of a transaction.
        */
        $transactionDetails->TransactionID = $request->get('transID');

        $request = new GetTransactionDetailsReq();
        $request->GetTransactionDetailsRequest = $transactionDetails;

        $paypalService = new PayPalAPIInterfaceServiceService(Configuration::getAcctAndConfig());

        //获取结果
        $transDetailsResponse = $paypalService->GetTransactionDetails($request);

        return $transDetailsResponse->PaymentTransactionDetails->PaymentInfo->PaymentStatus;
    }
}
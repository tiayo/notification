<?php

return [
	'APPID' => env('WXPAY_APPID'),
	'MCHID' => env('WXPAY_MCHID'),
	'KEY' => env('WXPAY_KEY'),
	'APPSECRET' => env('WXPAY_APPSECRET'),
    'NOTIFY_URL' => env('APP_URL').env('WXPAY_NOTIFY_URL'),
	'SSLCERT_PATH' => app_path().env('WXPAY_SSLCERT_PATH'),
	'SSLKEY_PATH' => app_path().env('WXPAY_SSLKEY_PATH'),
	'CURL_PROXY_HOST' => env('WXPAY_CURL_PROXY_HOST'),//"10.152.18.220";
	'CURL_PROXY_PORT' => env('WXPAY_CURL_PROXY_PORT'),//8080;
	'REPORT_LEVENL' => env('WXPAY_REPORT_LEVENL'),
];



<?php
return [
    //应用ID,您的APPID。
    'app_id' => env('ALIPAY_APP_ID'),

    //商户ID
    'seller_id' => env('ALIPAY_SELLER_ID'),

    //商户私钥文件路径
    'rsaPrivateKeyFilePath' => base_path().'/app_private_key.pem',

    //异步通知地址
    'notify_url' => env('APP_URL').env('ALIPAY_NOTIFY_URL'),

    //同步跳转
    'return_url' => env('APP_URL').env('ALIPAY_RETURN_URL'),

    //编码格式
    'charset' => env('ALIPAY_CHARSET'),

    //签名方式
    'sign_type'=> env('ALIPAY_SIGN_TYPE'),

    //支付宝网关
    'gatewayUrl' => env('ALIPAY_GATEWAYURL'),

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => env('ALIPAY_ALIPAY_PUBLIC_KEY'),
];
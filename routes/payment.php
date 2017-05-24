<?php

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //通用
    Route::get('/order/view/{order_id}', 'OrderController@view')->name('order_view');
    Route::get('/order/refund/{order_id}', 'OrderController@refundApply');
    Route::post('/order/refund/{order_id}', 'OrderController@refundSave');

    //支付宝
    Route::post('/alipay/pay', 'AlipayController@pay');
    Route::get('/alipay/callback', 'AlipayController@callback');

    //微信
    Route::get('/wxpay/query/{order_id}', 'WxpayController@query');
    Route::post('/wxpay/pay', 'WxpayController@pay');
    Route::get('/wxpay/pay/{order_id}', 'WxpayController@pay');
    Route::get('/wxpay/refresh/{order_id}', 'WxpayController@refresh');
    Route::get('/wxpay/callback/{order_id}', 'WxpayController@callback');

    //paypal
    Route::get('/paypal/query', 'PayPalController@index');
    Route::post('/paypal/query', 'PayPalController@query');

});

//异步通知
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::post('/alipay/app', 'AlipayController@app');
    Route::post('/wxpay/app', 'WxpayController@app');
});
<?php

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //通用
    Route::get('/order/view/{order_id}', 'OrderController@view')->name('order_view');

    //支付宝
    Route::get('/alipay/query/{order}', 'AlipayController@query');
    Route::post('/alipay/pay', 'AlipayController@pay');
    Route::get('/alipay/callback', 'AlipayController@callback');
    Route::get('/alipay/refund/{order_id}', 'AlipayController@refundView');
    Route::post('/alipay/refund/{order_id}', 'AlipayController@refundAction');

    //微信
    Route::get('/weixin/refund/{order_id}', 'WeixinController@refundView');
    Route::post('/weixin/refund/{order_id}', 'WeixinController@refundAction');
    Route::post('/weixin/pay', 'WeixinController@pay');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::post('/alipay/app', 'AlipayController@app');
    Route::post('/weixin/app', 'WeixinController@app');
});
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
    Route::get('/weixin/query/{order_id}', 'WeixinController@query');
    Route::post('/weixin/pay', 'WeixinController@pay');
    Route::get('/weixin/refresh/{order_id}', 'WeixinController@refresh');
    Route::get('/weixin/callback/{order_id}', 'WeixinController@callback');

});

//异步通知
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::post('/alipay/app', 'AlipayController@app');
    Route::post('/weixin/app', 'WeixinController@app');
});
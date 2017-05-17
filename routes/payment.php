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
    Route::get('/alipay/query/{order}', 'AlipayController@query');
    Route::get('/weixin/refund/{order_id}', 'WeixinController@refundView');
    Route::post('/weixin/refund/{order_id}', 'WeixinController@refundAction');
    Route::post('/weixin/pay', 'WeixinController@pay');
    Route::get('/weixin/refresh/{order_id}', 'WeixinController@refresh');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::post('/alipay/app', 'AlipayController@app');
    Route::get('/weixin/app', 'WeixinController@app');
    Route::post('/weixin/app', 'WeixinController@app');
});
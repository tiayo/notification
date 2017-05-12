<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //支付宝
    Route::get('/alipay/order/{order}', 'AlipayController@alipay')->name('alipay');
    Route::get('/alipay/query/{order}', 'AlipayController@query');
    Route::post('/alipay/pay', 'AlipayController@pay');
    Route::get('/alipay/callback', 'AlipayController@callback');
    Route::post('/alipay/app', 'AlipayController@app');
});
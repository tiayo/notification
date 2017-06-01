<?php

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin'], function () {
        //退款
        Route::get('/refund/page', function () {
            return redirect()->route('refund_page', ['page' => 1]);
        });
        Route::get('/refund/page/{page}', 'OrderController@refundList')->name('refund_page');

        //退款详情
        Route::get('/refund/view/{refund_id}', 'OrderController@refundView');

        //退款确认
        Route::get('/refund/confirm/{action}', 'OrderController@configmView');

        //执行退款操作
        Route::post('/refund/action/{action}', 'OrderController@refundAction');

        //管理分类
        Route::get('/category/page', function () {
            return redirect()->route('category', ['page' => 1]);
        });
        Route::get('/category/page/{page}', 'CategoryController@index')->name('category');

        //添加分类
        Route::get('/category/add', 'CategoryController@storeOrUpdateView');
        Route::post('/category/add', 'CategoryController@storeOrUpdate')->name('category_add');

        //更新分类
        Route::get('/category/update/{category_id}', 'CategoryController@storeOrUpdateView')->name('category_update');
        Route::post('/category/update/{category_id}', 'CategoryController@storeOrUpdate')->name('category_update_post');

        //删除分类
        Route::get('/category/delete/{id}', 'CategoryController@delete');

        //多选删除及选择修改(分类)
        Route::post('/category/select/', 'CategoryController@selectEvent');

        //生成视图
        Route::get('/generate/view', 'GenerateController@view');

        //生成操作
        Route::post('/generate/{option}', 'GenerateController@option');
    });
});
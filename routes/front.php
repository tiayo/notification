<?php

Route::get('/', 'FrontController@index');

Route::group(['middleware' => 'article'], function () {
    Route::post('/ajax/more_article/{category_id}/{page}', 'AjaxController@moreArticle');
    Route::get('/category/{category_id}', 'FrontController@category');
});

Route::get('/article/{article_id}', 'FrontController@article');
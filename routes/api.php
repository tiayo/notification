<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//API路由
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://192.168.20.99:8883',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://192.168.20.99:8883/oauth/authorize?'.$query);
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::get('/get_article', 'ApiController@getArticle');
    Route::post('/user', 'ApiController@post');
});

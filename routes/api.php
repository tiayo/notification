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
        'redirect_uri' => 'http://localhost',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://notification.app/oauth/authorize?'.$query);
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::get('/user', 'ApiController@get');
    Route::post('/user', 'ApiController@post');
});

<?php

//登录后路由组
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {

    //后台显示相关
    Route::get('/', 'IndexController@index');
    Route::get('/top', 'IndexController@top');
    Route::get('/left', 'IndexController@left');
    Route::get('/main', 'IndexController@main');
    Route::get('/sponsor', 'IndexController@sponsor');
    Route::post('/sponsor', 'IndexController@sponsor');

//------------------------------分隔线-------------------------------------------------//

    //任务显示
    Route::get('/task/page', function () {
        return redirect()->route('task_page', ['page' => 1]);
    });
    Route::get('/task/page/{page}', 'TaskController@show')->name('task_page');

    //添加任务
    Route::get('/task/add', function () {
        return redirect()->route('task_add', ['category' => app('\App\Repositories\CategoryRepositories')->routeFirst('task')['category_id']]);
    });
    Route::get('/task/add/{category}', 'TaskController@storeView')->name('task_add');
    Route::post('/task/add/{category}', 'TaskController@store')->name('task_add_post');

    //更新任务
    Route::get('/task/update/{task}', 'TaskController@UpdateView')->name('task_update');
    Route::post('/task/update/{task}', 'TaskController@update')->name('task_update_post');

    //删除任务
    Route::get('/task/delete/{id}', 'TaskController@destroy');

    //多选删除及选择修改(任务)
    Route::post('/task/select/', 'TaskController@selectEvent');

    //订单列表
    Route::get('/order/page', function () {
        return redirect()->route('order_page', ['page' => 1]);
    });
    Route::get('/order/page/{page}', 'OrderController@index')->name('order_page');

//------------------------------分隔线-------------------------------------------------//

    //文章显示
    Route::get('/article/page', function () {
        return redirect()->route('article_page', ['page' => 1]);
    });
    Route::get('/article/page/{page}', 'ArticleController@index')->name('article_page');

    //添加文章
    Route::get('/article/add', function () {
        return redirect()->route('article_add', ['category' => app('\App\Repositories\CategoryRepositories')->routeFirst('article')['category_id']]);
    });
    Route::get('/article/add/{category}', 'ArticleController@storeView')->name('article_add');
    Route::post('/article/add/{category}', 'ArticleController@store')->name('article_add_post');

    //更新文章
    Route::get('/article/update/{article}', 'ArticleController@UpdateView')->name('article_update');
    Route::post('/article/update/{article}', 'ArticleController@update')->name('article_update_post');

    //删除文章
    Route::get('/article/delete/{article_id}', 'ArticleController@destroy');

    //------------------------------分隔线-------------------------------------------------//

    //评论显示
    Route::get('/member/comment/page', function () {
        return redirect()->route('comment_page', ['page' => 1]);
    });
    Route::get('/member/comment/page/{page}', 'CommentController@index')->name('comment_page');

    //删除评论
    Route::get('/member/comment/delete/{comment_id}', 'CommentController@destroy');
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
$this->get('logout', 'Auth\LoginController@logout')->name('logout_get');
$this->get('lock', 'Auth\LoginController@lockView')->name('lock');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
<?php

//登录后路由（前端）
Route::group(['middleware' => 'auth', 'namespace' => 'Front'], function () {
    Route::get('/article/{article_id}', 'FrontController@article')->name('article_view');
});

//登录后路由组
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {

    //后台显示相关
    Route::get('/', 'IndexController@index')->name('admin');
    Route::get('/top', 'IndexController@top');
    Route::get('/left', 'IndexController@left');
    Route::get('/main', 'IndexController@main');
    Route::get('/sponsor', 'IndexController@sponsor')->name('sponsor');
    Route::post('/sponsor', 'IndexController@sponsor');


//------------------------------分隔线-------------------------------------------------//

    //任务显示
    Route::get('/task/page', function () {
        return redirect()->route('task_page', ['page' => 1]);
    })->name('task_page_simple');
    Route::get('/task/page/{page}', 'TaskController@show')->name('task_page');

    //添加任务
    Route::get('/task/add', function () {
        return redirect()->route('task_add', ['category' => app('\App\Repositories\CategoryRepository')->routeFirst('task')['category_id']]);
    })->name('task_add_simple');
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
    })->name('order_page_simple');
    Route::get('/order/page/{page}', 'OrderController@index')->name('order_page');

//------------------------------分隔线-------------------------------------------------//

    //文章显示
    Route::get('/article/page', function () {
        return redirect()->route('article_page', ['page' => 1]);
    })->name('article_page_simple');
    Route::get('/article/page/{page}', 'ArticleController@index')->name('article_page');

    //添加文章
    Route::get('/article/add', function () {
        return redirect()->route('article_add', ['category' => app('\App\Repositories\CategoryRepository')->routeFirst('article')['category_id']]);
    })->name('article_add_simple');
    Route::get('/article/add/{category}', 'ArticleController@storeView')->name('article_add');
    Route::post('/article/add/{category}', 'ArticleController@store')->name('article_add_post');

    //更新文章
    Route::get('/article/update/{article}', 'ArticleController@UpdateView')->name('article_update');
    Route::post('/article/update/{article}', 'ArticleController@update')->name('article_update_post');

    //删除文章
    Route::get('/article/delete/{article_id}', 'ArticleController@destroy');

    //后台搜索文章
    Route::get('/article/search/view', 'ArticleController@search')->name('admin_article_search');

    //------------------------------分隔线-------------------------------------------------//

    //评论显示
    Route::get('/member/comment/page', function () {
        return redirect()->route('comment_page', ['page' => 1]);
    })->name('comment_page_simple');
    Route::get('/member/comment/page/{page}', 'CommentController@index')->name('comment_page');

    //删除评论
    Route::get('/member/comment/delete/{comment_id}', 'CommentController@destroy');

    //------------------------------分隔线-------------------------------------------------//

    //查看资料
    Route::get('/member/me/view/', 'MeController@view')->name('me_view');

    //修改资料
    Route::get('/member/me/update/', 'MeController@updateView');
    Route::post('/member/me/update/', 'MeController@update')->name('me_update');

    //------------------------------分隔线-------------------------------------------------//

    //发送
    Route::get('/member/message/send/{target_id}', 'MessageController@sendView')->name('message_send_view');
    Route::post('/member/message/send/{target_id}', 'MessageController@send')->name('message_send');

    //收到的留言列表
    Route::get('/member/message/page/received', function () {
        return redirect()->route('message_received_page', ['page' => 1]);
    })->name('message_received_page_simple');
    Route::get('/member/message/page/received/{page}', 'MessageController@indexReceived')->name('message_received_page');

    //发出的的留言列表
    Route::get('/member/message/page/send', function () {
        return redirect()->route('message_send_page', ['page' => 1]);
    });
    Route::get('/member/message/page/send/{page}', 'MessageController@indexSend')->name('message_send_page');

    //设置留言状态
    Route::get('/member/message/read/{message_id}/{status}', 'MessageController@read');

    //删除
    Route::get('/member/message/delete/{message_id}', 'MessageController@destroy');

    //------------------------------分隔线-------------------------------------------------//

    //搜索导航
    Route::post('/search/slidebar', 'IndexController@searchSlidebar')->name('search_slidebar');
});

//记帐本路由
Route::group(['middleware' => 'auth', 'namespace' => 'Accounting', 'prefix' => 'admin'], function () {

    Route::get('/accounting/view', function () {
        return redirect()->route('accounting_view', ['page' => 1]);
    })->name('accounting_view_simple');
    Route::get('/accounting/view/{page}', 'IndexController@view')->name('accounting_view');

    Route::get('/accounting/add', 'IndexController@createView')->name('accounting_add');
    Route::post('/accounting/add', 'IndexController@createOrUpdate');

    Route::get('/accounting/update/{id}/{type}', 'IndexController@updateView')->name('accounting_update');
    Route::post('/accounting/update/{id}/{type}', 'IndexController@createOrUpdate');

    Route::get('/accounting/setup', 'IndexController@setupView')->name('accounting_setup');
    Route::post('/accounting/setup', 'IndexController@setupPost');

    Route::get('/accounting/delete/{id}', 'IndexController@destroy')->name('accounting_destroy');

    Route::get('/accounting/statistics', 'IndexController@statistics')->name('accounting_statistics');

    Route::get('/accounting/status/{id}', 'IndexController@status')->name('accounting_status');

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
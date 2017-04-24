<?php

//首页,返回登录页面
Route::get('/', function () {
    return view('auth.login');
});

//登录后路由组
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {

    //后台显示相关
    Route::get('/', 'IndexController@index');
    Route::get('/top', 'IndexController@top');
    Route::get('/left', 'IndexController@left');
    Route::get('/main', 'IndexController@main');

    //分页访问
    Route::get('/task/page', function () {
        return redirect()->route('task_page', ['page' => 1]);
    });
    Route::get('/task/page/{page}', 'TaskController@show')->name('task_page');

    //添加任务
    Route::get('/task/add', function () {
        return redirect()->route('task_add', ['category' => app('\App\Repositories\CategoryRepositories')->routeFirst()['id']]);
    });
    Route::get('/task/add/{category}', 'TaskController@store')->name('task_add');
});


// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
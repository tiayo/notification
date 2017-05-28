<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\Service\AuthenticatesUsers;
use App\Service\Loginservice;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use Loginservice;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected $request,$profile;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Profile $profile)
    {
        $this->request = $request;
        $this->profile = $profile;
        $this->middleware('guest')->except(['logout', 'lock', 'lockView']);
    }

    /**
     * 使用邮箱或用户名登录
     * 优先邮箱登录
     *
     * @return string
     */
    public function username()
    {
        //获取post数据
        $value = $this->request->all();

        //不同情况返回不同方法
        switch ($value) {
            case !empty($value['email']) :
                return 'email';
            case !empty($value['name']) :
                return 'name';
        }
    }
}

<?php

namespace App\Service;

use App\Repositories\ProfileRepositories;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Repositories\UserRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait Loginservice
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request, UserRepositories $user, ProfileRepositories $profile)
    {
        //离开模式用：记录解锁次数
        $request->session()->push('lock.num', 0);

        //验证登录字段
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            //获取上次登录时间
            $next_login_time = $user->selectFirst('updated_at', 'id', Auth::id())['updated_at'];

            //更新登录时间
            $user->update('id', Auth::id(), ['next_login_time' => $next_login_time ? : date('Y-m-d H:i:s')]);

            //删除离开模式的session
            $request->session()->forget('lock');

            //返回登录
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * 锁定屏幕
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lock()
    {
        //记录认证会员数据
        $user = Auth::user();

        //正常退出登录
        $this->guard()->logout();

        $this->request->session()->flush();

        $this->request->session()->regenerate();

        //储存信息到session
        $avatar = $this->profile->avator($user['id']);

        $this->request->session()->push('lock.status', true);

        $this->request->session()->push('lock.user_email', $user['email']);

        $this->request->session()->push('lock.user_name', $user['name']);

        $this->request->session()->push('lock.user_avatar', $avatar);

        $this->request->session()->push('lock.num', 0);

        //如过session信息找不到认证会员，转到登录界面
        if (empty($user['email']) && empty(session('lock.user_email'))) {
            return redirect()->route('login');
        }

        //退出成功
        return true;
    }

    protected $request;
    protected $profile;

    /**
     * 离开模式视图
     *
     * @param Request $request
     * @param ProfileRepositories $profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function lockView(Request $request, ProfileRepositories $profile)
    {
        if (!session('lock.status')[0]) {
            $this->request = $request;
            $this->profile = $profile;
            if ($this->lock()) {
                return redirect()->route('lock');
            }
        }

        return view('auth.lock', [
            'header' => false,
            'email' => session('lock.user_email')[0],
            'username' => session('lock.user_name')[0],
            'errors' => count(session('lock.num')) > 1 ? '请输入正确的密码解锁' : '',
            'avatar' => session('lock.user_avatar')[0],
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}

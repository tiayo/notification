<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\AjaxService;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    protected $ajax;

    public function __construct(AjaxService $ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * 更多文章
     *
     * @param $category_id
     * @param $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function moreArticle($category_id, $page)
    {
        return response()->json($this->ajax->moreArticle($category_id, $page));
    }

    /**
     * 判断用户登录状态
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginStatus()
    {
        if (Auth::check()) {
            return response()->json('login');
        }

        return response()->json('not_login', 403);
    }

    /**
     * 判断传入的id是否与当前登录用户id一致
     *
     * @param $user_id
     * @return bool
     */
    public function userIsIdentical($user_id)
    {
        if ($user_id == Auth::id()) {
            return null;
        }

        return response()->json(route('message_send_view', ['target_id' => $user_id]));
    }
}
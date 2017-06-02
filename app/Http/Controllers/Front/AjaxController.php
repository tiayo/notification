<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\AjaxService;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    protected $ajax;

    public function __construct(AjaxService $ajax)
    {
        $this->ajax = $ajax;
    }

    public function moreArticle($category_id, $page)
    {
        return response()->json($this->ajax->moreArticle($category_id, $page));
    }

    public function loginStatus()
    {
        if (Auth::check()) {
            return response()->json('login');
        }

        return response()->json('not_login', 403);
    }
}
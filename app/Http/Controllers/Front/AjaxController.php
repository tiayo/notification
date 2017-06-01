<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\AjaxService;

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
}
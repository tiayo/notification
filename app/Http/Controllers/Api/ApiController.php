<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FrontService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $request, $front;

    public function __construct(Request $request, FrontService $front)
    {
        $this->request = $request;
        $this->front = $front;
    }

    /**
     * 获取指定栏目指定篇数文章
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticle()
    {
        $category_id = $this->request->get('category_id') ?? 9;

        $num = $this->request->get('num') ?? 4;

        return response()->json(
            $this->front->getArticleLimitDescCategory($category_id, $num)
        );
    }

    public function post()
    {
        dd('post');
    }
}
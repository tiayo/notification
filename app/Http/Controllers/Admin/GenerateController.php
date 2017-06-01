<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\ArticleService;
use App\Service\CategoryService;
use App\Service\GenerateService;
use App\Service\IndexService;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    protected $generate;

    public  function __construct(GenerateService $generate)
    {
        $this->generate = $generate;
    }

    /**
     * 生成视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('home.article_generate', [

        ]);
    }

    /**
     * 生成入口
     *
     * @param $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function option($option)
    {
        try{
            $this->generate->option($option);
        } catch (\Exception $e) {
            return response()->json('生成失败!', 500);
        }

        return response()->json('生成完毕!');
    }
}

<?php

namespace App\Service;

use App\Http\Controllers\Front\FrontController;
use App\Repositories\ArticleRepositories;

class GenerateService
{
    protected $article;
    protected $front;

    public function __construct(ArticleRepositories $article, FrontController $front)
    {
        $this->article = $article;
        $this->front = $front;
    }

    public function option($option)
    {
         switch ($option) {
             case 'index' :
                 return $this->index();
                 break;
         }
    }

    public function index()
    {
        $data = $this->front->index()->__toString();

        //首页静态路径
        $path = public_path().'/index.html';

        //写入文件
        $fopen = fopen($path, 'w');
        fwrite($fopen, $data);
        fclose($fopen);

        return true;
    }
}
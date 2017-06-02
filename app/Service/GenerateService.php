<?php

namespace App\Service;

use App\Http\Controllers\Front\FrontController;
use App\Repositories\ArticleRepositories;
use App\Repositories\CategoryRepositories;
use Illuminate\Http\Request;

class GenerateService
{
    protected $article;
    protected $front;
    protected $category;
    protected $request;

    public function __construct(ArticleRepositories $article, FrontController $front, CategoryRepositories $category, Request $request)
    {
        $this->article = $article;
        $this->front = $front;
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * 生成首页
     *
     * @return bool
     * @throws \Exception
     */
    public function index()
    {
        //获取页面数据
        $data = $this->front->index()->__toString();

        //首页静态路径
        $path = public_path().'/index.html';

        //写入文件
        if ($this->fwrite($path, $data)) {
            return true;
        }

        throw new \Exception('生成失败！', 500);
    }

    /**
     * 生成列表
     *
     * @return bool
     */
    public function category()
    {
        //生成目录
        $path = public_path().'/category/';
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        //获取所有文章栏目id
        $all_caregory_id = $this->category->getWhereParent('article', ['category_id']);

        //循环生成
        foreach ($all_caregory_id as $category_id) {
            $id = $category_id->category_id;
            $data = $this->front->category($id)->__toString();
            $filename = $id.'.html';
            $this->fwrite($path.$filename, $data);
        }

        return true;
    }

    /**
     * 生成文章
     *
     * @return bool
     */
    public function article()
    {
        if (empty($this->request->get('category'))) {
            $all_article = $this->article->getArticleGennerate();
        } else {
            $all_article = $this->article->getArticleGennerateWhere($this->request->get('category'));
        }

        //循环生成页面
        foreach ($all_article as $article) {
            $id = $article->article_id;
            $data = $this->front->article($id)->__toString();
            $filename = $id.'.html';

            //生成目录
            $path = public_path().'/article'.$this->links($id);
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            //写入文件
            $this->fwrite($path.$filename, $data);
        }
        return true;
    }

    public function retrieval()
    {
        //获取所有文章
        $all_article = $this->article->retrieval();

        //初始化
        $html = '<meta charset="UTF-8">';

        //构建数据
        foreach ($all_article as $article) {
            $title = $article['title'];
            $links = config('site.article_path').$article['links'];
            $html .= "<a href='/".$links."' target='_blank'>$title</a><br>";
        }

        //生成目录
        $path = public_path().'/article/';
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        //写入文件
        return $this->fwrite($path.'/retrieval.html', $html);
    }

    /**
     * 写入文件
     *
     * @param $file
     * @param $data
     * @return bool
     */
    public function fwrite($file, $data)
    {
        try {
            $fopen = fopen($file, 'w');
            fwrite($fopen, $data);
            fclose($fopen);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
    /**
     * 根据文章ID生成URL
     *
     * @param $article_id
     * @return string
     */
    public function links($article_id)
    {
        //初始化
        $path = '/';

        //切割字符串
        $path_array = str_split($article_id, 1);

        //循环添加
        foreach ($path_array as $value) {
            $path .= $value . '/';
        }

        return $path;
    }
}
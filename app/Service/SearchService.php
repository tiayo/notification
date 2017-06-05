<?php

namespace App\Service;

use App\Article;
use App\Profile;
use App\SearchCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use TomLingham\Searchy\Facades\Searchy;

class SearchService
{
    /**
     * 接收控制器数据处理后返回
     *
     * @param $driver
     * @param $value
     * @param $page
     * @return array
     */
    public function article($driver, $value, $page)
    {
        //搜索是否有搜索记录
        $matching = Searchy::driver('matching')->search_cache('content')->query($value)->getQuery()->first();

        //如果不存在则创建并获取ID
        if (empty($matching)) {
            $result = $this->article_create($driver, $value);
        } else {
            $result = $this->article_cache($driver, $value, $matching);
        }

        //获取每页文章显示数量
        $num = Config('site.page');

        //判断是否有结果
        if (empty($result) || $result == "null") {
            return ['count' => 0 ,'data' => []];
        }

        //解析json数据
        $result = json_decode($result, true);

        //取出需要的数据
        $article_need = array_slice($result, ($page-1)*$num, $num);

        //取出非私密属性文章
        $article = $this->isAttribute($article_need);

        return ['count' => count($result) ,'data' => $article];
    }

    /**
     * 从redis数据库读搜索结果
     * 如果缓存时间超过设定阀值，将执行article_create方法
     *
     * @param $driver
     * @param $value
     * @param $matching
     * @return string
     */
    public function article_cache($driver, $value, $matching)
    {
        if (Carbon::parse($matching->updated_at)->addMinute(config('site.search_cache_time')) < Carbon::now()) {
            return $this->article_create($driver, $value, $matching);
        }

        return Redis::get('search_cache'.$matching->search_id);
    }

    /**
     * 搜索并写入redis数据库
     *
     * @param $driver
     * @param $value
     * @param null $matching
     * @return string
     */
    public function article_create($driver, $value, $matching = null)
    {
        //没有获取到id，则创建，否则更新
        if (empty($matching)) {
            $search_id = SearchCache::create([
                'content' => $value
            ])->search_id;
        } else {
            SearchCache::where('search_id', $matching->search_id)->update([
                'frequency' => ($matching->frequency + 1),
            ]);
            $search_id = $matching->search_id;
        }

        //获取搜索结果(排除私密信息)
        $result = Searchy::driver($driver)->article('title', 'abstract')->query($value)->getQuery()->where('attribute', '<>', '2')->get()->toArray();

        //转为json数据存储
        $result = json_encode($this->object_to_array($result));

        //存储到redis
        Redis::set('search_cache'.$search_id, $result);

        return $result;
    }

    /**
     * object转array数组
     *
     * @param $obj
     * @return array
     */
    public function object_to_array($obj){
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        $arr = null;
        foreach($_arr as $key=>$val){
            $val = (is_array($val))||is_object($val) ? $this->object_to_array($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }

    /**
     * array转object数组
     *
     * @param $obj
     * @return object
     */
    public function array_to_object($obj){
        foreach ($obj as $key=>$item) {
            if (gettype($item)=='array' || getType($item)=='object') {
                $obj[$key] = (object)$this->array_to_object($item);
            }
        }
        return (object)$obj;
    }

    /**
     * 整理非私密属性文章，并加入porfile表信息
     *
     * @param $article_need
     * @return array
     */
    public function isAttribute($article_need)
    {
        $article = [];

        foreach ($article_need as $item) {
            //判断是否私密文章
            $attribute = Article::select('attribute')->where('article_id', $item['article_id'])->first();
            if ($attribute['attribute'] != 2) {
                //加入真实姓名信息
                $item['real_name'] = Profile::find($item['user_id'])['real_name'];
                $article[] = $item;
            }

            continue;
        }

        return $article;
    }
}
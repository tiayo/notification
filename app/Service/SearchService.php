<?php

namespace App\Service;

use App\Profile;
use App\SearchCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use TomLingham\Searchy\Facades\Searchy;

class SearchService
{
    public function article($driver, $value, $page)
    {
        $article = [];

        //搜索是否有搜索记录
        $matching = Searchy::driver('matching')->search_cache('content')->query($value)->getQuery()->first();

        //如果不存在则创建并获取ID
        if (empty($matching)) {
            $result = $this->article_create($driver, $value);
        } else {
            $result = $this->article_cache($driver, $value, $matching);
        }

        $num = Config('site.page');

        //判断是否有结果
        if (empty($result)) {
            return $result;
        }

        //解析json数据
        $result = json_decode($result, true);

        foreach ($result as $item) {
            $item['real_name'] = Profile::find($item['user_id'])['real_name'];
            $article[] = $item;
        }

        return ['count' => count($result) ,'data' => array_slice($article, ($page-1)*$num, $num)];
    }

    public function article_cache($driver, $value, $matching)
    {
        if (Carbon::parse($matching->updated_at)->addMinute(config('site.search_cache_time')) < Carbon::now()) {
            return $this->article_create($driver, $value, $matching);
        }

        return Redis::get('search_cache'.$matching->search_id);
    }

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

        //获取搜索结果
        $result = Searchy::driver($driver)->article('title', 'abstract')->query($value)->get()->toArray();

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
}
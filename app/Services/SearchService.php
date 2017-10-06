<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\SearchCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use TomLingham\Searchy\Facades\Searchy;

class SearchService
{
    protected $article;
    protected $searchCache;

    public function __construct(ArticleRepository $article, SearchCache $searchCache)
    {
        $this->article = $article;
        $this->searchCache = $searchCache;
    }

    /**
     * 调度方法
     *
     * @param $value
     * @return string
     */
    public function article($value)
    {
        //搜索是否有搜索记录
        $matching = $this->searchCache
            ->where('content', $value)
            ->first();

        //如果不存在则创建并获取ID
        if (empty($matching)) {
            return $this->article_create($value);
        } else {
            return $this->article_cache($value, $matching);
        }
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
    public function article_cache($value, $matching)
    {
//        Carbon::parse($matching->updated_at)->addMinute(config('site.search_cache_time')) < Carbon::now()
        if (true) {
            return $this->article_create($value, $matching);
        }

        return unserialize(Redis::get('search_cache'.$matching->search_id));
    }

    /**
     * 搜索并写入redis数据库
     *
     * @param $driver
     * @param $value
     * @param null $matching
     * @return string
     */
    public function article_create($value, $matching = null)
    {
        //没有获取到id，则创建，否则更新
        if (empty($matching)) {
            $search_id = $this->searchCache
                ->create(['content' => $value])
                ->search_id;
        } else {
            $this->searchCache->where('search_id', $matching->search_id)
                ->update(
                    ['frequency' => ($matching->frequency + 1),]
                );
            $search_id = $matching->search_id;
        }

        //获取搜索结果(排除私密信息)
        $result = $this->article->getSearch($value);

        //存储到redis
        Redis::set('search_cache'.$search_id, serialize($result));

        return $result;
    }
}
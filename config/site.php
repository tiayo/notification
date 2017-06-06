<?php

return [
    'title' => env('SITE_TITLE'),
    'url' => env('APP_URL'),
    'version' => env('SITE_VERSION'),
    'adminstrator' => env('SITE_ADMINISTRATOR'),
    'page' => env('SITE_PAGE'),//后台列表每页显示条数
    'screen_task' => env('SCREENTASK', '1000'),//查询任务时每次查询数量（根据服务器质量设置）
    'article_path' => env('SITE_ARTICLE_PATH', 'article'), //文章存储路径
    'index_page' => env('SITE_INDEX_PAGE', 10),//首页每页显示条数
    'more_article' => env('SITE_MORE_ARTICLE', 2),//更多文章每次显示出来的数量
    'search_cache_time' => env('SITE_SEARCH_CACHE_TIME', 30),//搜索数据缓存时间
    'comment_article_limit' => env('SITE_COMMENT_ARTICLE_LIMIT', 3),//每篇文章每个用户最多评论数量
];

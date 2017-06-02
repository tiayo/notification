<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;


class IsArticleList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $category = new Category;
        $category_id = $request->route('category_id');

        //0为特殊情况，代表所有文章栏目
        if ($category_id != 0) {
            $parent_id = $category::where('alias', 'article')->first()['category_id'];
            $result = $category::find($category_id);

            if (empty($result) || $result['parent_id'] != $parent_id) {
                return response()->json('不是文章栏目或栏目不存在，请检查！');
            }
        }

        return $next($request);
    }
}
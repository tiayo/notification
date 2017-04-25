<?php

namespace App\Service;

use App\Repositories\CategoryRepositories;
use App\Repositories\TackRepositories;
use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $category;

    public function __construct(CategoryRepositories $category)
    {
        $this->category = $category;
    }

    /**
     * 获取所有分类（获取主要字段）
     * @return array
     */
    public function getSelect()
    {
        $value = ['name','parent_id','id'];
        return $this->category->selectGet($value)->toArray();
    }

    /**
     * 获取所有分类（有指定字段）
     * @return array
     */
    public function get()
    {
        return $this->category->selectGet()->toArray();
    }


    /**
     * 根据id获取分类
     * @param $category_id
     * @return mixed
     */
    public function current($category_id)
    {
        return $this->category->current($category_id);
    }

    /**
     * 根据条件获取分类
     * @param $page 页码
     * @param $num 每页显示条数
     * @return mixed
     */
    public function show($page, $num)
    {
        return $this->category->show($page, $num);
    }

    public function count()
    {
        return $this->category->count();
    }
}

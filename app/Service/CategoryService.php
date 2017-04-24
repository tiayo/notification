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
     * 获取所有分类
     * @return array
     */
    public function getSelect()
    {
        $value = ['name','parent_id','id'];
        return $this->category->selectGet($value)->toArray();
    }
}

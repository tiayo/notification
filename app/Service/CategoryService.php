<?php

namespace App\Service;

use App\Repositories\CategoryRepositories;
use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $category;
    protected $user;

    public function __construct(CategoryRepositories $category, UserRepositories $user)
    {
        $this->category = $category;
        $this->user = $user;
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
        if (!$this->user->find(Auth::id())->can('Admin', CategoryService::class)) {
            throw new \Exception('您没有权限访问！', 403);
        }

        $all_category = $this->category->show($page, $num)->toarray();

        foreach ($all_category as $item) {
            $item['parent_name'] = $this->category->selectWhereFirst('name', 'id', $item['parent_id'])['name'] ? : '顶级';
            $result_category[] = $item;
        }

        return $result_category;
    }

    /**
     * 统计分类个数
     * @return int
     */
    public function count()
    {
        return $this->category->count();
    }

    public function store($name, $parent_id, $alias)
    {
        $data = [
            'name' => $name,
            'parent_id' => $parent_id,
            'alias' => $alias
        ];

        var_dump($data);
        exit();

        return $this->category->store($data);
    }

}

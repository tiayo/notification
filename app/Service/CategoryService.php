<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\CategoryRepositories;
use App\Repositories\UserRepositories;

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
        $value = ['name','parent_id','category_id'];
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
     * 非管理操作抛403
     * @param $page 页码
     * @param $num 每页显示条数
     * @return mixed
     */
    public function show($page, $num)
    {
        //权限验证
        Verfication::admin(CategoryService::class);

        $all_category = $this->category->show($page, $num)->toarray();

        foreach ($all_category as $item) {
            $item['parent_name'] = $this->category->selectWhereFirst('name', 'category_id', $item['parent_id'])['name'] ? : '顶级';
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

    /**
     * 插入分类
     *
     * @param $name
     * @param $parent_id
     * @param $alias
     * @return mixed
     */
    public function store($name, $parent_id, $alias)
    {
        $data = [
            'name' => $name,
            'parent_id' => $parent_id,
            'alias' => $alias
        ];

        return $this->category->store($data);
    }

    /**
     * 更新分类
     *
     * @param $name
     * @param $parent_id
     * @param $alias
     * @param $category_id
     * @param $old
     * @return mixed
     */
    public function update($name, $parent_id, $alias, $category_id, $old)
    {
        //复制模板文件
        $old_alias = $old['alias'];
        if ($alias != $old_alias) {
            if ($old_alias == 'alarm' || $old_alias == 'default') {
                copy(dirname(__DIR__)."/../resources/views/home/$old_alias.blade.php",dirname(__DIR__)."/../resources/views/home/$alias.blade.php");
            } else {
                if ($alias == 'alarm' || $alias == 'default') {
                    unlink(dirname(__DIR__)."/../resources/views/home/$old_alias.blade.php");
                } else {
                    rename(dirname(__DIR__)."/../resources/views/home/$old_alias.blade.php",dirname(__DIR__)."/../resources/views/home/$alias.blade.php");
                }
            }
        }

        //构造更新数组
        $data = [
            'name' => $name,
            'parent_id' => $parent_id,
            'alias' => $alias
        ];

        return $this->category->update($data, $category_id);
    }

    /**
     * 删除分类
     * 非管理员操作抛403
     *
     * @param $id
     */
    public function delete($id)
    {
        //权限验证
        Verfication::admin(CategoryService::class);

        return $this->category->delete($id);
    }

}

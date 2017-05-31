<?php

namespace App\Service;

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
     *
     * @return array
     */
    public function getSelect()
    {
        $value = ['name','parent_id','category_id'];
        return $this->category->selectGet($value)->toArray();
    }

    /**
     * 获取所有分类（有指定字段）
     *
     * @return array
     */
    public function get()
    {
        return $this->category->selectGet()->toArray();
    }

    /**
     * 根据id获取分类
     *
     * @param $category_id
     * @return mixed
     */
    public function current($category_id)
    {
        return $this->category->current($category_id);
    }

    /**
     * 根据条件获取分类
     *
     * @param $page 页码
     * @param $num 每页显示条数
     * @return mixed
     */
    public function show($page, $num)
    {
        $all_category = $this->category->show($page, $num)->toarray();

        foreach ($all_category as $item) {
            $item['parent_name'] = $this->category->selectWhereFirst('name', 'category_id', $item['parent_id'])['name'] ? : '顶级';
            $result_category[] = $item;
        }

        return $result_category;
    }

    /**
     * 统计分类个数
     *
     * @return int
     */
    public function count()
    {
        return $this->category->count();
    }

    /**
     * 插入或更新分类
     *
     * @param $name
     * @param $parent_id
     * @param $alias
     * @param null $category_id
     * @return mixed
     */
    public function storeOrUpdate($name, $parent_id, $alias, $category_id = null)
    {
        $data = [
            'name' => $name,
            'parent_id' => $parent_id,
            'alias' => $alias
        ];

        if (empty($category_id)) {
            return $this->category->store($data);
        }

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
        return $this->category->delete($id);
    }

    /**
     * checkbox事件
     * 进行批量删除及选择修改
     * 删除需要权限验证
     *
     * @param $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectEvent($post)
    {
        $judge = $post['judge'];
        if ($judge == 'modified') {
            return $this->selectModified($post['check'][0]);
        } else if ($judge == 'delete') {
            return $this->selectDelete($post['check']);
        }

        return redirect()->route('category', ['page' => 1]);
    }

    /**
     * checkbox 修改事件
     *
     * @param $task_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectModified($category_id)
    {
        return redirect()->route('category_update', ['category_id' => $category_id]);
    }

    /**
     * checkbox 删除事件
     * 有权限验证
     * 只可以删除自己的任务，违规id会被忽略
     *
     * @param $check
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectDelete($check)
    {
        foreach ($check as $item) {
            try {
                $this->delete($item);
            } catch (\Exception $e) {
                continue;
            }
        }
        return redirect()->route('category', ['page' => 1]);
    }

    public function categoryHtml($str, $option)
    {
        $all_category = $this->category->getWhereParent($option);
        $result = null;
        foreach ($all_category as $key => $category) {
            $re = $str;
            $re = str_replace('<<title>>',$category['name'],$re);
            $re = str_replace('<<category_id>>',$category['category_id'],$re);
            $re = str_replace('<<num>>',$key,$re);
            $result .= $re;
        }

        return $result;
    }

}

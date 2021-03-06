<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

   public function get()
   {
       return $this->category->get();
   }

   public function selectGet($select = '*')
   {
       return $this->category
           ->select($select)
           ->get();
   }

   public function selectWhereFirst($value = '*', $option, $str)
   {
       return $this->category
           ->select($value)
           ->where($option, $str)
           ->first();
   }

   public function routeFirst($option)
   {
       $parent_id = $this->category
           ->where('alias', $option)
           ->first()
           ->category_id;

       return $this->category
           ->select('name','parent_id','category_id')
           ->where('parent_id', $parent_id)
           ->first();
   }

   public function current($category_id)
   {
        return $this->category
            ->select('name','parent_id','category_id', 'alias')
            ->where('category_id', $category_id)
            ->first();
   }

   public function show($page, $num)
   {
        return $this->category
            ->skip(($page-1)*$num)
            ->take($num)
            ->where('parent_id', '<>', 0)
            ->orderBy('category_id', 'desc')
            ->get();
   }

   public function count()
   {
       return $this->category->count();
   }

   public function store($data)
   {
       return $this->category
           ->create($data);
   }

   public function update($data, $category_id)
   {
       return $this->category
           ->where('category_id', $category_id)
           ->update($data);
   }

   public function delete($id)
   {
       return $this->category
           ->where('category_id', $id)
           ->delete();
   }

   public function getWhereParent($option, $select = '*')
   {
        $parent_id = $this->category
            ->where('alias', $option)
            ->first()['category_id'];

        return $this->category
            ->select($select)
            ->where('parent_id', $parent_id)
            ->get();
   }

    public function getSimple($where, ...$select)
    {
        return $this->category
            ->select($select)
            ->where($where)
            ->get();
    }
}
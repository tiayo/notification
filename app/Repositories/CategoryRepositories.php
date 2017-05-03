<?php

namespace App\Repositories;

use App\Category;

class CategoryRepositories
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

   public function selectGet($value = '*')
   {
       return $this->category
           ->select($value)
           ->get();
   }

   public function selectWhereFirst($value = '*', $option, $str)
   {
       return $this->category
           ->select($value)
           ->where($option, $str)
           ->first();
   }

   public function routeFirst()
   {
       return $this->category
           ->select('name','parent_id','category_id')
           ->where('parent_id', '<>', 0)
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

}
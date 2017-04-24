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

   public function selectGet($value)
   {
       return $this->category
           ->select($value)
           ->get();
   }

   public function routeFirst()
   {
       return $this->category
           ->select('name','parent_id','id')
           ->where('parent_id', '<>', 0)
           ->first();
   }

   public function current($category_id)
   {
        return $this->category
            ->select('name','parent_id','id', 'alias')
            ->where('id', $category_id)
            ->first();
   }

}
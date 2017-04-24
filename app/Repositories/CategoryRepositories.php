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

}
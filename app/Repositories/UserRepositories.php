<?php

namespace App\Repositories;

use App\User;

class UserRepositories
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

   public function find($id)
   {
       return $this->user->find($id);
   }

   public function selectFirst($select, $option, $value)
   {
       return $this->user
           ->select($select)
           ->where($option, $value)
           ->first();
   }

    public function update($option, $value, $array)
    {
        return $this->user
            ->where($option, $value)
            ->update($array);
    }
}
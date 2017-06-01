<?php

namespace App\Repositories;

use App\User;

class UserRepositories
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

   public function find($id)
   {
       return $this->user->find($id);
   }

   public function findAndProfile($id)
   {
       return $this->user
           ->join('profile', 'users.id', '=', 'profile.user_id')
           ->where('id', $id)
           ->first();
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
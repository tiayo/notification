<?php

namespace App\Repositories;

use App\Profile;

class ProfileRepositories
{
    protected $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function findProfileJoinUser($user_id)
    {
        return $this->profile
            ->join('users', 'users.id', '=', 'profile.user_id')
            ->where('user_id', $user_id)
            ->first();
    }

    public function avator($user_id)
    {
        return $this->profile
            ->select('avatar')
            ->where('user_id', $user_id)
            ->first()['avatar'];
    }
}
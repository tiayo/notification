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

    public function findFirst($user_id)
    {
        return $this->profile->where('user_id', $user_id)->first();
    }

    public function avator($user_id)
    {
        return $this->profile
            ->select('avatar')
            ->where('user_id', $user_id)
            ->first()['avatar'];
    }
}
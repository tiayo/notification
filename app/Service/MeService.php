<?php

namespace App\Service;

use App\Repositories\ProfileRepositories;
use Illuminate\Support\Facades\Auth;

class MeService
{
    protected $profile;

    public function __construct(ProfileRepositories $profile)
    {
        $this->profile = $profile;
    }

    public function update($data)
    {
        //处理头像
        if (!empty($data['avatar'])) {
            $value['avatar'] = ImagesUploadService::updaloadImage($data['avatar']);
        }

        //处理地址
        if ($data['address1'][3] == '市辖区' || $data['address1'][3] == '县') {
            $address1_3 = '/';
        } else {
            $address1_3 = '/'.$data['address1'][3].'/';
        }

        //其他数据
        $value['user_id'] = Auth::id();
        $value['phone'] = $data['phone'];
        $value['real_name'] = $data['real_name'] ?? Auth::user()['name'];
        $value['age'] = $data['age'];
        $value['address1'] = $data['address1'][2].$address1_3.$data['address1'][4];
        $value['address2'] = $data['address2'];
        $value['address_code'] = $data['address1'][0].'/'.$data['address1'][1];

        //写入
        return $this->profile->update('user_id', Auth::id(), $value);
    }

    public function address($profile)
    {
        $address = [];

        //切割数据
        $address_array = explode('/', $profile['address1']);
        $address_code = explode('/', $profile['address_code']);

        //组合数组
        if (!empty($address_code)) {
            $address[0] = $address_code[0] ?? null;
            $address[1] = $address_code[1] ?? null;
        }

        if (count($address_array) == 2) {
            $address[2] = $address_array[0];
            $address[3] = null;
            $address[4] = $address_array[1];
        } elseif (count($address_array) == 3) {
            $address[2] = $address_array[0];
            $address[3] = $address_array[1];
            $address[4] = $address_array[2];
        }

        return $address;
    }
}
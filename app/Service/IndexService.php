<?php

namespace App\Service;

use App\Facades\Verfication;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Facades\Auth;

class IndexService
{

    protected $verfication;
    protected $order;

    public function __construct(VerficationService $verfication, OrderRepositories $order)
    {
        $this->verfication = $verfication;
        $this->order = $order;
    }

    /**
     * 判断是否为管理
     * 管理员返回true
     * 非管理返回false
     *
     * @return bool
     */
    static public function admin()
    {
        try {
            Verfication::admin(IndexService::class);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sponsor($money)
    {
        $user_id = Auth::id();
        $data = [
            'order_number' => $user_id.date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'user_id' => $user_id,
            'title' => '赞助'.config('site.title'),
            'content' => '赞助'.config('site.title').$money.'块钱',
            'total_amount' => $money,
        ];

        return $this->order->create($data);
    }

    /**
    * 后台搜索
    *
    * @return array
    */
    public function searchSlidebar($keyword)
    {
        //初始化
        $key_level = [];

        //获取配置文件
        $array = config('slidebar.slidebar');

        //搜索
        $key = $this->searchSlidebarHandle($array, $keyword);

        //如果搜索没有结果，返回false
        if (!$key) {
            return ['key_level' => false, 'array_key' => false];
        }

        //切割
        $key_array = explode('_', $key);

        //获取各级key
        $num = count($key_array);
        for ($i=1; $i < $num; $i++) {
            $key_level[] = $this->keyLevel($i, $key_array);
        }

        //返回结果
        return ['key_level' => $key_level, 'array_key' => $key];
    }

    /**
     * 计算各级目录key
     *
     * @param $array
     * @param $key
     * @return array
     */
    public function keyLevel($num, $key_array)
    {
        $str = null;

        for ($i=0; $i <= $num; $i++) {
            if ($i<$num) {
                $str .= $key_array[$i].'_';
            } else if($i = $num) {
                $str .= $key_array[$i];
            }
        }

        return $str;
    }

    /**
     * 数组模糊搜索
     *
     * @param $array
     * @param $keyword
     * @return int|string
     */
    public function searchSlidebarHandle($array, $keyword)
    {
        foreach ($array as $key => $value) {
            $length = mb_strlen($keyword,'UTF8');
            $arr = $this->mb_str_split($value, $length);
            foreach ($arr as $item) {
                if ($item == $keyword) {
                    return $key;
                }
            }
        }
        return false;
    }

    /**
     * 切割中文字符串
     *
     * @param $str
     * @param int $split_length
     * @param string $charset
     * @return array|bool
     */
    public function mb_str_split($str, $split_length=1, $charset='UTF-8'){
        if (func_num_args() == 1) {
            return preg_split('/(?<!^)(?!$)/u', $str);
        }
        if ($split_length < 1) {
            return false;
        }
        $len = mb_strlen($str, $charset);
        $arr = array();
        for ($i=0; $i<$len; $i+=$split_length) {
            $s = mb_substr($str, $i, $split_length, $charset);
            $arr[] = $s;
        }
        return $arr;
    }
}

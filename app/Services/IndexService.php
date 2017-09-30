<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class IndexService
{

    protected $verfication;
    protected $order;

    public function __construct(VerficationService $verfication, OrderRepository $order)
    {
        $this->verfication = $verfication;
        $this->order = $order;
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
        //超过15个字符自动裁剪（一个中文和一个英文均算1）
        if (mb_strlen($keyword) > 15) {
            $keyword = $this->mb_str_split($keyword, 15);
        }

        //初始化
        $key_level = [];

        //获取配置文件
        $original = config('sidebar.original');
        $array = json_decode(Redis::get('sidebar_generate'), true)['generate'];

        //搜索
        $key = $this->searchSlidebarHandle($array, $keyword);

        //如果搜索没有结果，返回false
        if (!$key) {
            return ['info' => '抱歉，未找到合适的结果！', 'key_level' => false, 'array_key' => false];
        }

        //切割
        $key_array = explode('_', $key);

        //获取各级key
        $num = count($key_array);
        for ($i=1; $i < $num; $i++) {
            $key_level[] = $this->keyLevel($i, $key_array);
        }

        //返回结果
        return ['info' => '为您智能匹配到"'.$original[$key].'"', 'key_level' => $key_level, 'array_key' => $key];
    }

    /**
     * 计算各级目录key
     *
     * @param $array
     * @param $key
     * @return string
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
     *  数组模糊搜索，成功返回符合的数组项键值
     *
     * @param $array
     * @param $keyword
     * @return int|string
     */
    public function searchSlidebarHandle($array, $keyword)
    {
        //初始化
        $result = [];

        //循环查找
        foreach ($array as $key => $value) {
            $keyword_array = $this->mb_str_split($keyword);
            $result[$key] = count(array_intersect($keyword_array, $value));
        }

        //获取并返回符合项的键值
        return array_keys($result, max($result))[0] ?? false;
    }

    /**
     * 切割中文字符串
     *
     * @param $str
     * @param int $split_length
     * @param string $charset
     * @return array|bool
     */
    public function mb_str_split($str, $split_length = 1, $charset = 'UTF-8'){
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

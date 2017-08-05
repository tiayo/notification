<?php

namespace App\Services;

class ImagesUploadService
{
    /**
     * 保存上传的图片
     *
     * @param $file
     * @return bool
     * @throws \Exception
     */
    public static function updaloadImage($file)
    {
        if (!is_file($file)) {
            return $file;
        }

        $file_size = round($file->getSize() / 1024);
        $file_ex = $file->getClientOriginalExtension();

        //判断图片是否为jpg、png、gif格式之一
        if (!in_array($file_ex, array('jpg', 'png', 'gif'))){
            throw new \Exception('图片格式必须为jpg、png、gif！');
        }

        //判断图片是否大于设置大小
        if ($file_size > config('site.upload_image_size')) {
            throw new \Exception('图片必须小于'.config('site.upload_image_size').'Kb！');
        }

        //文件名
        $filename = uniqid().".".$file_ex;

        //保存路径
        $path = '/upload/'.date('Ymd').'/';

        //目录不存在则创建
        if (!file_exists(public_path().$path)) {
            mkdir(public_path().$path, 0775, true);
        }

        //保存图片
        $file -> move(public_path().$path, $filename);

        //返回图片路径
        return $path.$filename;
    }
}
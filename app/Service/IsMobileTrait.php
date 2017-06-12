<?php

namespace App\Service;

trait IsMobileTrait
{
    public static function isMobile()
    {
        //初始化
        $is_mobile = false;

        //数据
        $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
        $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');

        //循环判断一：
        foreach ($mobile_os_list as $key => $value) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $value)) {
                $is_mobile = true;
            }
        }

        //循环判断二
        foreach ($mobile_token_list as $key => $value) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $value)) {
                $is_mobile = true;
            }
        }

        //返回结果
        return $is_mobile;
    }
}
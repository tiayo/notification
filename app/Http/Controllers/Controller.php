<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public static function plan($id)
    {
        switch ($id) {
            case 1 :
                return '单次';
                break;
            case 2 :
                return '每天';
                break;
            case 3 :
                return '工作日（周一到周五）';
                break;
            case 4 :
                return '工作日（周一到周六）';
                break;
            case 5 :
                return '工作日（跳过法定节假日）';
                break;
        }
    }
}
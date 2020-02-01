<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 15:15
 */

namespace app\models\snow\user\dto;


use app\models\base\Dto;

class UserAuthorizationResponse extends Dto
{
    public $token;
}
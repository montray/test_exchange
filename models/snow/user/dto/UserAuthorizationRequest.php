<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 14:24
 */

namespace app\models\snow\user\dto;



use app\models\base\Dto;
use yii\web\Request;

class UserAuthorizationRequest extends Dto
{
    public $login;
    public $password;
}
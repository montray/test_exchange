<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 19:25
 */

namespace app\models\snow\request\dto;


use app\models\base\Dto;

class RequestAcceptRequest extends Dto
{
    public $orderId;
    public $requestId;
}
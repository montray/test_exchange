<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:14
 */

namespace app\models\snow\order\dto;


use app\models\base\Dto;

class OrderDoneRequest extends Dto
{
    public $orderId;
}
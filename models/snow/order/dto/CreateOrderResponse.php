<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:05
 */

namespace app\models\snow\order\dto;


use app\models\base\Dto;

class CreateOrderResponse extends Dto
{
    public $orderId;
}
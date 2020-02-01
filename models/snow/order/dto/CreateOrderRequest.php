<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:04
 */

namespace app\models\snow\order\dto;


use app\models\base\Dto;

class CreateOrderRequest extends Dto
{
    public $name;
    public $description;
    public $expiresAt;
    public $agentComission;
}
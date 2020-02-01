<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:15
 */

namespace app\models\snow\order;


use app\models\snow\order\Order;

interface OrderRepositoryInterface
{
    public function getById(int $id) :Order;

    public function save(Order $order);
}
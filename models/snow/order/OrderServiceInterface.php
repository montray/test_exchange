<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:03
 */

namespace app\models\snow\order;


use app\models\snow\order\dto\CreateOrderRequest;
use app\models\snow\order\dto\CreateOrderResponse;
use app\models\snow\order\dto\OrderDoneRequest;
use app\models\snow\request\dto\RequestAcceptRequest;

interface OrderServiceInterface
{
    public function create(CreateOrderRequest $dto) :CreateOrderResponse;

    public function accept(RequestAcceptRequest $dto);

    public function complete(OrderDoneRequest $dto);
}
<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:47
 */

namespace app\models\snow\request;


interface RequestRepositoryInterface
{
    public function getById(int $id): Request;

    public function getByOrderAndUserId(int $orderId, int $userId): ?Request;

    public function save(Request $request);
}
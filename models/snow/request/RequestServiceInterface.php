<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:46
 */

namespace app\models\snow\request;


use app\models\snow\request\dto\RequestAcceptRequest;
use app\models\snow\request\dto\RequestCreateRequest;
use app\models\snow\request\dto\RequestCreateResponse;

interface RequestServiceInterface
{
    public function create(RequestCreateRequest $dto) :RequestCreateResponse;
}
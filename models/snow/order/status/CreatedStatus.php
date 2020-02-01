<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:45
 */

namespace app\models\snow\order\status;


class CreatedStatus extends Status
{
    public $index = 1;

    protected $next = [ProcessingStatus::class, RejectedStatus::class];

    public function allowsAcceptingRequest(): bool
    {
        return true;
    }
}
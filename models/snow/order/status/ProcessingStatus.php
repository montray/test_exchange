<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:58
 */

namespace app\models\snow\order\status;


class ProcessingStatus extends Status
{
    public $index = 2;

    protected $next = [CompletedStatus::class, RejectedStatus::class];

    public function allowsAcceptingRequest(): bool
    {
        return false;
    }
}
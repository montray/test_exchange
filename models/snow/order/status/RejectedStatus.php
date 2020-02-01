<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:56
 */

namespace app\models\snow\order\status;


class RejectedStatus extends Status
{
    public $index = 0;

    protected $next = [];

    public function allowsAcceptingRequest(): bool
    {
        return true;
    }
}
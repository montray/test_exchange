<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:53
 */

namespace app\models\snow\order\status;


class CompletedStatus extends Status
{
    public $index = 3;

    protected $next = [];

    public function allowsAcceptingRequest(): bool
    {
        return false;
    }
}
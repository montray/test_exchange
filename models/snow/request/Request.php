<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 30.01.2020
 * Time: 16:20
 */

namespace app\models\snow\request;


use app\models\snow\order\Order;
use app\models\snow\order\status\Status;
use app\models\snow\user\User;

class Request
{
    private $id;
    private $order;
    private $performer;
    private $status;

    public function __construct(int $id, Order $order, User $performer, Status $status)
    {
        $this->id = $id;
        $this->order = $order;
        $this->performer = $performer;
        $this->status = $status;
    }

    public function getId() :?int
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return User
     */
    public function getPerformer(): User
    {
        return $this->performer;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @throws \DomainException
     */
    public function changeStatus(Status $status)
    {
        try {
            $this->status->canBeChangedTo($status);
            $this->status = $status;
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}
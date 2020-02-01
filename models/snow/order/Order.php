<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 30.01.2020
 * Time: 16:18
 */

namespace app\models\snow\order;


use app\models\snow\order\status\ProcessingStatus;
use app\models\snow\order\status\Status;
use app\models\snow\request\Request;
use app\models\snow\user\User;

class Order
{
    private $id;
    private $name;
    private $description;
    private $expiresAt;
    private $agent;
    private $agentComission;
    /** @var Request */
    private $request;
    private $status;

    public function __construct(int $id, string $name, string $description, \DateTimeImmutable $expiresAt, $agentComission, User $agent, Status $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->expiresAt = $expiresAt;
        $this->agentComission = $agentComission;
        $this->agent = $agent;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    /**
     * @return User
     */
    public function getAgent(): User
    {
        return $this->agent;
    }

    /**
     * @return mixed
     */
    public function getAgentComission()
    {
        return $this->agentComission;
    }

    /**
     * @param Request $request
     * @throws \DomainException
     */
    public function acceptRequest(Request $request)
    {
        if ($this->request) {
            throw new \DomainException('Заявка на данный заказ уже принята');
        }

        if (!$this->status->allowsAcceptingRequest() || $request->getPerformer()->getId() === $this->agent->getId()) {
            throw new \DomainException('Нельзя принять заявку');
        }

        $this->request = $request;
        $this->changeStatus(new ProcessingStatus());
    }

    /**
     * @return Request
     */
    public function getRequest() :?Request
    {
        return $this->request;
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

            if ($this->request) {
                $this->request->getStatus()->canBeChangedTo($status);
                $this->request->changeStatus($status);
            }
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}
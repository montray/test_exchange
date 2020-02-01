<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:56
 */

namespace app\models\snow\request;


use app\models\snow\order\OrderRepositoryInterface;
use app\models\snow\order\status\Status;
use app\models\snow\request\dto\RequestAcceptRequest;
use app\models\snow\request\dto\RequestCreateRequest;
use app\models\snow\request\dto\RequestCreateResponse;
use app\models\snow\user\User;

class RequestService implements RequestServiceInterface
{
    private $requestRepository;
    private $orderRepository;
    private $user;

    public function __construct(RequestRepositoryInterface $requestRepository, OrderRepositoryInterface $orderRepository, User $user)
    {
        $this->requestRepository = $requestRepository;
        $this->orderRepository = $orderRepository;
        $this->user = $user;
    }

    public function create(RequestCreateRequest $dto) :RequestCreateResponse
    {
        try {
            $order = $this->orderRepository->getById($dto->orderId);

            if ((int)$order->getAgent()->getId() === (int)$this->user->getId()) {
                throw new \DomainException('Создатель заявки не может подать заявку');
            }

            if ($this->requestRepository->getByOrderAndUserId($order->getId(), $this->user->getId())) {
                throw new \DomainException('Нельзя подать две заявки на один заказ');
            }

        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }

        $request = new Request(0, $order, $this->user, Status::create(Status::STATUS_CREATED));
        $this->requestRepository->save($request);

        $response = new RequestCreateResponse();
        $response->requestId = $request->getId();

        return $response;
    }
}
<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 30.01.2020
 * Time: 16:22
 */

namespace app\models\snow\order;

// implements OrderServiceInterface
use app\models\snow\order\dto\CreateOrderRequest;
use app\models\snow\order\dto\CreateOrderResponse;
use app\models\snow\order\dto\OrderDoneRequest;
use app\models\snow\order\OrderRepositoryInterface;
use app\models\snow\order\status\CompletedStatus;
use app\models\snow\order\status\CreatedStatus;
use app\models\snow\order\status\Status;
use app\models\snow\request\dto\RequestAcceptRequest;
use app\models\snow\request\RequestRepositoryInterface;
use app\models\snow\request\RequestServiceInterface;
use app\models\snow\user\User;

class OrderService implements OrderServiceInterface
{
    private $orderRepository;
    private $requestRepository;
    private $user;

    public function __construct(OrderRepositoryInterface $orderRepository, RequestRepositoryInterface $requestRepository, User $user)
    {
        $this->orderRepository = $orderRepository;
        $this->requestRepository = $requestRepository;
        $this->user = $user;
    }

    public function create(CreateOrderRequest $dto): CreateOrderResponse
    {
        $order = new Order(
            0,
            $dto->name,
            $dto->description,
            new \DateTimeImmutable($dto->expiresAt),
            $dto->agentComission,
            $this->user,
            new CreatedStatus()
        );

        $this->orderRepository->save($order);

        $response = new CreateOrderResponse();
        $response->orderId = $order->getId();

        return $response;
    }

    public function accept(RequestAcceptRequest $dto)
    {
        try {
            $order = $this->orderRepository->getById($dto->orderId);
            $request = $this->requestRepository->getById($dto->requestId);
            $order->acceptRequest($request);
            $this->orderRepository->save($order);
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        } catch (\Throwable $e) {
            throw new \DomainException('Возникла ошибка');
        }
    }

    public function complete(OrderDoneRequest $dto)
    {
        try {
            $order = $this->orderRepository->getById($dto->orderId);
            if ($order->getAgent()->getId() !== (int)$this->user->getId()) {
                throw new \DomainException('Нельзя изменять чужой заказ');
            }
            $order->changeStatus(new CompletedStatus());
            $this->orderRepository->save($order);
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}
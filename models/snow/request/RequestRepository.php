<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 21:04
 */

namespace app\models\snow\request;


use app\models\snow\order\Order;
use app\models\snow\order\status\Status;
use app\models\snow\user\User;

class RequestRepository implements RequestRepositoryInterface
{
    private $request;

    public function __construct(\app\models\db\Request $request)
    {
        $this->request = $request;
    }

    public function getById(int $id): Request
    {
        $arRequest = $this->request::findOne(['id' => $id]);
        if (!$arRequest) {
            throw new \DomainException('Заявка не найдена');
        }

        $agent = $arRequest->order->agent;
        $performer = $arRequest->user;

        return new Request(
            $arRequest->id,
            new Order(
                $arRequest->order->id,
                $arRequest->order->name,
                $arRequest->order->description,
                new \DateTimeImmutable($arRequest->order->expiresAt),
                $arRequest->order->agentComission,
                new User(
                    $agent->id,
                    $agent->login,
                    $agent->password,
                    $agent->name,
                    $agent->phone,
                    $agent->type
                ),
                Status::create($arRequest->order->status)
            ),
            new User(
                $performer->id,
                $performer->login,
                $performer->password,
                $performer->name,
                $performer->phone,
                $performer->type
            ),
            Status::create($arRequest->status)
        );
    }

    public function save(Request $request)
    {
        if (!$request->getId()) {
            $arRequest = new \app\models\db\Request();
        } else {
            $arRequest = $this->request::findOne(['id' => $request->getId()]);
            // TODO exception if not found ??
        }

        $arRequest->orderId = $request->getOrder()->getId();
        $arRequest->userId = $request->getPerformer()->getId();
        $arRequest->status = $request->getStatus()->getIndex();

        $arRequest->save();

        $reflection = new \ReflectionObject($request);
        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($request, $arRequest->id);
    }

    public function getByOrderAndUserId(int $orderId, int $userId): ?Request
    {
        $request = $this->request::findOne(['orderId' => $orderId, 'userId' => $userId]);
        if (!$request) {
            return null;
        }

        return $this->getById($request->id);
    }
}
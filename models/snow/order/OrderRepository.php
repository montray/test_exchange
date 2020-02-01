<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:15
 */

namespace app\models\snow\order;



use app\models\snow\order\status\Status;
use app\models\snow\request\Request;
use app\models\snow\user\User;

class OrderRepository implements OrderRepositoryInterface
{
    private $order;
    private $request;

    public function __construct(\app\models\db\Order $order, \app\models\db\Request $request)
    {
        $this->order = $order;
        $this->request = $request;
    }

    public function getById(int $id): Order
    {
        $dbOrder = $this->order::findOne(['id' => $id]);

        if (!$dbOrder) {
            throw new \DomainException('Заказ не найден');
        }

        $order = new Order(
            $dbOrder->id,
            $dbOrder->name,
            $dbOrder->description,
            new \DateTimeImmutable($dbOrder->expiresAt),
            $dbOrder->agentComission,
            new User(
                $dbOrder->agent->id,
                $dbOrder->agent->login,
                $dbOrder->agent->password,
                $dbOrder->agent->name,
                $dbOrder->agent->phone,
                $dbOrder->agent->type
            ),
            Status::create($dbOrder->status)
        );

        /** @var \app\models\db\Request $request */
        $request = $this->request::find()
            ->where(['orderId' => $dbOrder->id])
            ->andWhere(['status' => [Status::STATUS_PROCESSING, Status::STATUS_COMPLETED]])
            ->one();

        if ($request) {
            $ref = new \ReflectionObject($order);
            $prop = $ref->getProperty('request');
            $prop->setAccessible(true);
            $prop->setValue($order, new Request(
                $request->id,
                $order,
                new User(
                    $request->user->id,
                    $request->user->login,
                    $request->user->password,
                    $request->user->name,
                    $request->user->phone,
                    $request->user->type
                ),
                Status::create($request->status)
            ));
        }

        return $order;
    }

    public function save(\app\models\snow\order\Order $order)
    {
        /** @var \app\models\db\Order $arOrder */
        if (!$order->getId()) {
            $arOrder = new \app\models\db\Order();
        } else {
            $arOrder = \app\models\db\Order::findOne(['id' => $order->getId()]);
        }

        $arOrder->name = $order->getName();
        $arOrder->description = $order->getDescription();
        $arOrder->expiresAt = $order->getExpiresAt()->format('Y-m-d');
        $arOrder->agentId = $order->getAgent()->getId();
        $arOrder->agentComission = $order->getAgentComission();
        $arOrder->status = $order->getStatus()->getIndex();
        $arOrder->save();

        if ($request = $order->getRequest()) {
            $arRequest = $request->getId() ? \app\models\db\Request::findOne(['id' => $request->getId()]) : new \app\models\db\Request();
            $arRequest->userId = $request->getPerformer()->getId();
            $arRequest->orderId = $arOrder->id;
            $arRequest->status = $request->getStatus()->getIndex();
            $arRequest->save();
        }

        $reflection = new \ReflectionObject($order);
        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($order, $arOrder->id);
    }
}
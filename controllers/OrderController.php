<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 17:07
 */

namespace app\controllers;


use app\models\snow\order\dto\CreateOrderRequest;
use app\models\snow\order\dto\OrderDoneRequest;
use app\models\snow\order\OrderServiceInterface;
use app\models\snow\request\dto\RequestAcceptRequest;
use app\models\snow\user\UserRepositoryInterface;
use app\system\JwtHttpBearerXAuth;
use app\system\Serializer;
use sizeg\jwt\Jwt;
use yii\rest\Controller;

class OrderController extends Controller
{
    public $serializer = Serializer::class;

    private $orderService;
    private $userRepository;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerXAuth::class,
            'optional' => [
                'auth'
            ]
        ];

        return $behaviors;
    }

    public function __construct($id, $module, UserRepositoryInterface $userRepository, $config = [])
    {
        $this->userRepository = $userRepository;

        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $dto = CreateOrderRequest::createFromRequest(\Yii::$app->request);

        $user = $this->userRepository->getById(\Yii::$app->user->getId());
        /** @var OrderServiceInterface $orderService */
        $orderService = \Yii::$container->get(OrderServiceInterface::class, [2 => $user]);

        try {
            return $orderService->create($dto);
        } catch (\DomainException $e) {
            return $e;
        }
    }

    public function actionAccept()
    {
        $dto = RequestAcceptRequest::createFromRequest(\Yii::$app->request);

        $user = $this->userRepository->getById(\Yii::$app->user->getId());
        /** @var OrderServiceInterface $orderService */
        $orderService = \Yii::$container->get(OrderServiceInterface::class, [2 => $user]);

        try {
            $orderService->accept($dto);
            return 'Заявка принята';
        } catch (\DomainException $e) {
            return $e;
        }
    }

    public function actionDone()
    {
        $dto = OrderDoneRequest::createFromRequest(\Yii::$app->request);
        $user = $this->userRepository->getById(\Yii::$app->user->getId());
        /** @var OrderServiceInterface $orderService */
        $orderService = \Yii::$container->get(OrderServiceInterface::class, [2 => $user]);

        try {
            $orderService->complete($dto);
            return 'Заказ успешно помечен как выполненный';
        } catch (\DomainException $e) {
            return $e;
        }
    }
}
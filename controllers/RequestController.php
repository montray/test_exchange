<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 02.02.2020
 * Time: 0:00
 */

namespace app\controllers;


use app\models\snow\request\dto\RequestCreateRequest;
use app\models\snow\request\RequestServiceInterface;
use app\models\snow\user\UserRepositoryInterface;
use app\system\JwtHttpBearerXAuth;
use app\system\Serializer;
use yii\rest\Controller;

class RequestController extends Controller
{
    public $serializer = Serializer::class;

    private $userRepository;
    private $requestService;

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
        $dto = RequestCreateRequest::createFromRequest(\Yii::$app->request);
        $user = $this->userRepository->getById(\Yii::$app->user->getId());

        /** @var RequestServiceInterface $requestService */
        $requestService = \Yii::$container->get(RequestServiceInterface::class, [2 => $user]);

        try {
            return $requestService->create($dto);
        } catch (\DomainException $e) {
            return $e;
        }
    }
}
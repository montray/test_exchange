<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 13:27
 */

namespace app\controllers;


use app\models\snow\user\dto\UserAuthorizationRequest;
use app\models\snow\user\UserServiceInterface;
use app\system\JwtHttpBearerXAuth;
use app\system\Serializer;
use yii\rest\Controller;

class ApiController extends Controller
{
    public $serializer = Serializer::class;

    private $userService;

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

    public function __construct($id, $module, UserServiceInterface $service, $config = [])
    {
        $this->userService = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionAuth()
    {
        $dto = UserAuthorizationRequest::createFromRequest(\Yii::$app->request);
        try {
            $response = $this->userService->authorization($dto);
        } catch (\Throwable $e) {
            return $e;
        }

        return $response;
    }
}
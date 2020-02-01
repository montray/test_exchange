<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 30.01.2020
 * Time: 16:22
 */

namespace app\models\snow\user;

// implements UserServiceInterface
use app\models\snow\user\dto\UserAuthorizationRequest;
use app\models\snow\user\dto\UserAuthorizationResponse;
use app\models\snow\user\UserRepositoryInterface;
use yii\web\UnauthorizedHttpException;

class UserService implements UserServiceInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // TODO
    public function registration(UserRegistrationDTO $dto)
    {

    }

    public function authorization(UserAuthorizationRequest $dto) :UserAuthorizationResponse
    {
        try {
            $user = $this->repository->getByLogin($dto->login);
        } catch (\DomainException $e) {
            throw new UnauthorizedHttpException('Не верные логин/пароль');
        }

        // TODO упрощенная проверка
        if ($user->getPassword() !== $dto->password) {
            throw new UnauthorizedHttpException('Не верные логин/пароль');
        }

        // TODO ?? вынести jwt в di
        /** @var \sizeg\jwt\Jwt $jwt */
        $jwt = \Yii::$app->jwt;
        $token = $jwt->getBuilder()
            ->withClaim('id', $user->getId())
            ->expiresAt(time() + 3600)
            ->getToken($jwt->getSigner('HS256'), $jwt->getKey());

        $response = new UserAuthorizationResponse();
        $response->token = (string)$token;

        return $response;
    }

    // TODO
    public function edit(UserEditDTO $dto)
    {

    }

    // TODO
    public function getInformation() :UserInformationDTO
    {

    }
}
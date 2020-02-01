<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 13:28
 */

namespace app\models\snow\user;


use app\models\snow\user\dto\UserAuthorizationRequest;
use app\models\snow\user\dto\UserAuthorizationResponse;

interface UserServiceInterface
{
    public function registration(UserRegistrationDTO $dto);

    public function authorization(UserAuthorizationRequest $dto) :UserAuthorizationResponse;

    public function edit(UserEditDTO $dto);
}
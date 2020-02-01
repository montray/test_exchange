<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 13:18
 */

namespace app\models\snow\user;


interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User
     * @throws \DomainException
     */
    public function getById(int $id) :User;

    /**
     * @param string $login
     * @return User
     * @throws \DomainException
     */
    public function getByLogin(string $login) :User;
}
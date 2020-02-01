<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 13:25
 */

namespace app\models\snow\user;


use yii\db\Connection;

class UserRepository implements UserRepositoryInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $id) :User
    {
        $query = $this->connection->createCommand('SELECT id, login, password, name, phone, type FROM users WHERE id = :id', ['id' => $id]);
        $data = $query->queryOne();

        if (empty($data)) {
            throw new \DomainException('User not found');
        }

        $user = new User(...array_values($data));
        return $user;
    }

    public function getByLogin(string $login) :User
    {
        $query = $this->connection->createCommand('SELECT id, login, password, name, phone, type FROM users WHERE login = :login', ['login' => $login]);
        $data = $query->queryOne();

        if (empty($data)) {
            throw new \DomainException('User not found');
        }

        $user = new User(...array_values($data));
        return $user;
    }
}
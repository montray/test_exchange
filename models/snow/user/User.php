<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 30.01.2020
 * Time: 16:18
 */

namespace app\models\snow\user;


class User
{
    protected $id;
    protected $login;
    protected $password;
    protected $name;
    protected $phone;
    protected $type;

    public function __construct($id, $login, $password, $name, $phone, $type)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
        $this->phone = $phone;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
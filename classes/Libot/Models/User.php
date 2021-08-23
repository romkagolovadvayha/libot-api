<?php

namespace Libot\Models;

class User
{
    /**
     * @var \Libot\TradeBotRepository
     */
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function addUser($login, $password, $fullname)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
        if (empty($password)) {
            throw new \ErrorException('Введите пароль!', 450);
        }
        if (empty($fullname)) {
            throw new \ErrorException('Имя не заполнено!', 450);
        }
        $this->repository->addUser($login, $password, $fullname);
    }

    public function getUser($login)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
       return $this->repository->getUser($login);
    }

    public function updateUser($login, $password = null, $fullname = null)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
        $this->repository->updateUser($login, $password, $fullname);
    }

}

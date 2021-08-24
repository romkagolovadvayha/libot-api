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

    public function addUser($login, $password, $fullname, $token)
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
        $this->repository->addUser($login, $password, $fullname, $token);
    }

    public function getUser($login)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
       return $this->repository->getUser($login);
    }

    public function getUserByToken()
    {
        $headers = apache_request_headers();
        $token = $headers['X-Token'] ?? null;
        if (empty($token)) {
            throw new \ErrorException('Ошибка авторизации er241!', 453);
        }
       return $this->repository->getUserByToken($token);
    }

    public function updateUser($login, $password = null, $fullname = null)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
        $this->repository->updateUser($login, $password, $fullname);
    }

    public function checkAuthUser()
    {
        $headers = apache_request_headers();
        $token = $headers['X-Token'] ?? null;
        if (empty($token)) {
            throw new \ErrorException('Ошибка авторизации er242!', 453);
        }
        $user = $this->repository->getUserByToken($token);
        if (empty($user)) {
            throw new \ErrorException('Ошибка авторизации er243!', 453);
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user['userAgent'] !== $userAgent) {
            throw new \ErrorException('Ошибка авторизации er244!', 453);
        }
        if ($user['ip'] !== $ip) {
            throw new \ErrorException('Ошибка авторизации er245!', 453);
        }
    }

}

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

    public function addUser($login, $password, $fullname, $email, $recaptcha, $token)
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
        if (empty($email)) {
            throw new \ErrorException('Email не заполнен!', 450);
        }
        $user = $this->repository->getUser($login);
        if ($user) {
            throw new \ErrorException('Логин уже используется!', 450);
        }
        if (\Libot\Models\Recaptcha::validateRechapcha($recaptcha) !== true) {
            throw new \ErrorException('Антиспам система не пройдена!', 403);
        }
        $this->repository->addUser($login, $password, $fullname, $email, $token);
    }

    public function getUser($login)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
       return $this->repository->getUser($login);
    }

    public function authorization($login, $password, $recaptcha, $token)
    {
        if (empty($login)) {
            throw new \ErrorException('Введите логин!', 450);
        }
        if (empty($password)) {
            throw new \ErrorException('Введите пароль!', 450);
        }
        $user = $this->repository->getUserAuthorization($login, $password);
        if (empty($user)) {
            throw new \ErrorException('Неверный логин или пароль!', 450);
        }
        if (\Libot\Models\Recaptcha::validateRechapcha($recaptcha) !== true) {
            throw new \ErrorException('Антиспам система не пройдена!', 403);
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->repository->updateUser($login, null, null, null, $token, $userAgent, $ip);
        return $user;
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

    public function updateUser($login, $password = null, $fullname = null, $email = null, $token = null)
    {
        $this->repository->updateUser($login, $password, $fullname, $email, $token);
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

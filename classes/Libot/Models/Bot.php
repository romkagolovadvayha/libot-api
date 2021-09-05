<?php

namespace Libot\Models;

class Bot
{
    /**
     * @var \Libot\TradeBotRepository
     */
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function addBot($userId, $params)
    {
        if (empty($userId)) {
            throw new \ErrorException('Введите id пользователя!', 450);
        }
        $botId = $this->repository->addBot($userId);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $this->repository->addBotSettings($botId, $key, $value);
            }
        }
    }

    public function updateBot($botId, $active, $params)
    {
        if (empty($botId)) {
            throw new \ErrorException('Введите botId пользователя!', 450);
        }
        $this->repository->updateBot($botId, $active);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (!empty($this->repository->getBotSetting($botId, $key))) {
                    $this->repository->updateBotSettings($botId, $key, $value);
                } else {
                    $this->repository->addBotSettings($botId, $key, $value);
                }
            }
        }
    }

    public function getBots($userId)
    {
        $bots = array_map(function ($bot) {
            $settingsResponse = $this->repository->getBotSettings($bot['id']);
            $settings = [];
            foreach ($settingsResponse as $setting) {
                $settings[$setting['name']] = $setting['value'];
            }
            $bot['settings'] = (object) $settings;
            return $bot;
        }, $this->repository->getBots($userId));
        return $bots;
    }

}

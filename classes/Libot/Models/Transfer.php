<?php

namespace Libot\Models;

class Transfer
{
    /**
     * @var \Libot\TradeBotRepository
     */
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function addTransfer($botId, $currencyBuy, $sumBuy, $currencySell)
    {
        if (empty($botId)) {
            throw new \ErrorException('Введите botId!', 450);
        }
        if (empty($currencyBuy)) {
            throw new \ErrorException('Введите валюту покупки!', 450);
        }
        if (empty($sumBuy)) {
            throw new \ErrorException('Введите сумму покупки!', 450);
        }
        if (empty($currencySell)) {
            throw new \ErrorException('Введите валюту продажи!', 450);
        }
        $this->repository->addTransfer($botId, $currencyBuy, $sumBuy, $currencySell);
    }

    public function getTransfers($botId)
    {
        return $this->repository->getTransfers($botId);
    }

}

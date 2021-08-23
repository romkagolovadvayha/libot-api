<?php

namespace Libot\Models;

class Listing
{
    /**
     * @var \Libot\TradeBotRepository
     */
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function addListing($channel, $currency)
    {
        if (empty($channel)) {
            throw new \ErrorException('Введите источник!', 450);
        }
        if (empty($currency)) {
            throw new \ErrorException('Введите валюту!', 450);
        }
        $this->repository->addListing($channel, $currency);
    }

    public function getListings()
    {
        return $this->repository->getListings();
    }

}

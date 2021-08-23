<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$transfersUseCase = new \Libot\Models\Transfer($tradeBotRepository);

$botId = filter_input(INPUT_POST, 'botId', FILTER_SANITIZE_STRING);
$currencyBuy = filter_input(INPUT_POST, 'currencyBuy', FILTER_SANITIZE_STRING);
$sumBuy = filter_input(INPUT_POST, 'sumBuy', FILTER_SANITIZE_STRING);
$currencySell = filter_input(INPUT_POST, 'currencySell', FILTER_SANITIZE_STRING);

try {
    $transfersUseCase->addTransfer($botId, $currencyBuy, $sumBuy, $currencySell);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$transfersUseCase = new \Libot\Models\Transfer($tradeBotRepository);

$botId = filter_input(INPUT_GET, 'botId', FILTER_SANITIZE_STRING);

$transfers = [];
try {
    $transfers = $transfersUseCase->getTransfers($botId);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'response' => ['transfers' => $transfers]]);
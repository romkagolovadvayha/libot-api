<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$transfersUseCase = new \Libot\Models\Transfer($tradeBotRepository);

$json = file_get_contents('php://input');
if (empty($json)) {
    echo json_encode(['status' => 403]);
    exit;
}
$data = json_decode($json, 1);

$botId = $data['botId'];
$currencyBuy = $data['currencyBuy'];
$sumBuy = $data['sumBuy'];
$currencySell = $data['currencySell'];

try {
    $transfersUseCase->addTransfer($botId, $currencyBuy, $sumBuy, $currencySell);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
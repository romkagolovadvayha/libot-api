<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$listingUseCase = new \Libot\Models\Listing($tradeBotRepository);

$channel = filter_input(INPUT_POST, 'channel', FILTER_SANITIZE_STRING);
$currency = filter_input(INPUT_POST, 'currency', FILTER_SANITIZE_STRING);

try {
    $listingUseCase->addListing($channel, $currency);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
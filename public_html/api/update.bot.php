<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

// /api/update.bots.php?botId=7&active=0&params[apiKey]=123123&params[name]=test2%20name&params[procent]=5

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$useCase = new \Libot\Models\Bot($tradeBotRepository);

$botId = filter_input(INPUT_POST, 'botId', FILTER_SANITIZE_STRING);
$active = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_STRING);
$params = [];

if (!empty($_REQUEST['params'])) {
    $params = $_REQUEST['params'];
}

try {
   $useCase->updateBot($botId, $active, $params);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
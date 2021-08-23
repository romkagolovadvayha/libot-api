<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

// /api/add.bot.php?userId=5&params[apiKey]=123&params[name]=test%20name&&params[procent]=5

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$useCase = new \Libot\Models\Bot($tradeBotRepository);

$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_STRING);
$params = [];

if (!empty($_REQUEST['params'])) {
    $params = $_REQUEST['params'];
}

try {
   $useCase->addBot($userId, $params);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
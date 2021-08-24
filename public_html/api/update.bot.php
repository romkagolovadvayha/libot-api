<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

// /api/update.bots.php?botId=7&active=0&params[apiKey]=123123&params[name]=test2%20name&params[procent]=5

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$useCase = new \Libot\Models\Bot($tradeBotRepository);
$userUseCase = new \Libot\Models\User($tradeBotRepository);

$json = file_get_contents('php://input');
if (empty($json)) {
    echo json_encode(['status' => 403]);
    exit;
}
$data = json_decode($json, 1);

$botId = $data['botId'];
$active = $data['active'];
$params = [];

if (!empty($data['params'])) {
    $params = $data['params'];
}

try {
   $userUseCase->checkAuthUser();
   $useCase->updateBot($botId, $active, $params);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
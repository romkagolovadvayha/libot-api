<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

// /api/add.bot.php?userId=5&params[apiKey]=123&params[name]=test%20name&&params[procent]=5

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

try {
   $userUseCase->checkAuthUser();
   $user = $userUseCase->getUserByToken();
   $useCase->addBot($user['id'], $data);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200]);
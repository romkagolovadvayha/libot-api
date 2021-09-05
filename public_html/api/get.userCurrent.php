<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$userUseCase = new \Libot\Models\User($tradeBotRepository);
//sleep(1);
$user = null;
try {
    $userUseCase->checkAuthUser();
    $user = $userUseCase->getUserByToken();
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'user' => $user]);
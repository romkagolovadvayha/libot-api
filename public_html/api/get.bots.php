<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$useCase = new \Libot\Models\Bot($tradeBotRepository);
$userUseCase = new \Libot\Models\User($tradeBotRepository);

$bots = [];
try {
    $userUseCase->checkAuthUser();
    $user = $userUseCase->getUserByToken();
    $bots = $useCase->getBots($user['id']);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'response' => ['bots' => $bots]]);
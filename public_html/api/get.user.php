<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$userUseCase = new \Libot\Models\User($tradeBotRepository);

$login = filter_input(INPUT_GET, 'login', FILTER_SANITIZE_STRING);

$user = null;
try {
    $user = $userUseCase->getUser($login);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'response' => ['user' => $user]]);
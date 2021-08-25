<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config             = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$userUseCase        = new \Libot\Models\User($tradeBotRepository);


$json = file_get_contents('php://input');
if (empty($json)) {
    echo json_encode(['status' => 403, 'error' => 'Ошибка доступа!']);
    exit;
}
$data = json_decode($json, 1);

$token = \Libot\User\Token::execute();
$user = null;
try {
    $user = $userUseCase->authorization($data['login'], $data['password'], $data['recaptcha'], $token);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'user' => $user, 'token' => $token]);
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/autoload.php';

use RozbynDev\Api\Telegram;
use RozbynDev\BonusSystem\AnswersMaker;
use RozbynDev\BonusSystem\Client;
use RozbynDev\Helper\Logger;
use RozbynDev\Helper\Path;

$dumm = '{"1": "1"}';

$data = json_decode(file_get_contents('php://input') ?: $dumm, true, 512, JSON_THROW_ON_ERROR);

$logger = new Logger(__DIR__ . '/webhookTarget.log');
$logger->log($data);


$fromId = (int)($data['message']['from']['id'] ?? $data['callback_query']['from']['id']);
if ($fromId <= 0) {
    return $logger->log('Client id not found');
}
AnswersMaker::setWebAppUrl(Path::getPathUrl(__DIR__.'/webApp.php'));
$existClient = Client::getById($fromId);
$logger->log($existClient);
if (!$existClient) {
    $existClient = Client::createNewClient($fromId);
    Telegram::sendMessage($fromId, AnswersMaker::getFirstMetParams());
}
$result = (new AnswersMaker($existClient, $data))->makeAnswer();

$logger->log($result);

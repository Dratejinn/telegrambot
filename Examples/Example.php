<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/../vendor/autoload.php';

use Telegram\API\Base\InputFile;
use Telegram\API\Method\SendMediaGroup;
use Telegram\API\Type\InputMediaPhoto;

$token = '';
$chat = 0;

$res = ConfigManager::AddConfigFromJSONFile(__DIR__ . '/../TelegramConfig.json');

if ($res === TRUE) {
    $token = ConfigManager::GetConfig('BotToken');
    $chat = (int) ConfigManager::GetConfig('ChatId');
}
$logger = new \Monolog\Logger('TostiBotLogger');
$format = "%datetime% | %level_name% | %context.botname% | %message% %context% %extra%\n";
$formatter = new \Monolog\Formatter\LineFormatter($format, NULL, FALSE, TRUE);
$processor = new \Telegram\LogHelpers\LengthProcessor([
    'level_name' => 8
], [
    'botname' => 10
]);
$logger->pushProcessor($processor);
$cliLog = new \Monolog\Handler\StreamHandler(STDOUT, \Monolog\Logger::DEBUG);
$cliLog->setFormatter($formatter);
$logger->pushHandler($cliLog);


$bot = new Bot($token, $logger);

if (!$chat) {
    echo 'Unable to load stuff from config!' . PHP_EOL;
    exit(0);
}

$inputMedia1 = new InputMediaPhoto;
$inputMedia1->setAttachment(new InputFile(__DIR__ . '/test1.png'));

$inputMedia2 = new InputMediaPhoto;
$inputMedia2->setAttachment(new InputFile(__DIR__ . '/test2.png'));

$sendInputMedia = new SendMediaGroup;
$sendInputMedia->chatId = $chat;
$sendInputMedia->media = [$inputMedia1, $inputMedia2];

$sendInputMedia->call($bot);

$pieces = $argv;
array_shift($pieces);
$message  = implode(' ', $pieces);

$sendMessage = new Method\SendMessage;
$sendMessage->chatId = $chat;
$sendMessage->text = $message;
$res = $sendMessage->call($bot);

$sendLocation = new Method\SendVenue;
$sendLocation->chatId = $chat;
$sendLocation->latitude = 52.2938802;
$sendLocation->longitude = 4.7089148;
$sendLocation->title = 'Brightfish B.V.';
$sendLocation->address = 'Wegalaan 46';

$result = $sendLocation->call($bot);


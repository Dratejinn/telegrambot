<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/../vendor/autoload.php';

use Telegram\API\Base\InputFile;
use Telegram\API\Method\GetMyCommands;
use Telegram\API\Method\SendAnimation;
use Telegram\API\Method\SendDice;
use Telegram\API\Method\SendMediaGroup;
use Telegram\API\Stickers\Method\SendSticker;
use Telegram\API\Type\InputMediaPhoto;

ConfigManager::AddConfigFromINIFile(__DIR__ . '/../Tokens.ini', 'token');
ConfigManager::AddConfigFromINIFile(__DIR__ . '/../Chats.ini', 'chat');
$tokens = ConfigManager::GetConfig('token');
$token = $tokens['devbot']['token'];

$chats = ConfigManager::GetConfig('chat');
$chat = $chats['private']['chatId'];

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

$getMyCommands = new GetMyCommands;
var_dump($getMyCommands->call($bot));

$sendDice = new SendDice;
$sendDice->chatId = $chat;
$sendDice->call($bot);


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

if (empty($message)) {
    $message = 'No text provided :(';
}

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

$sendLocation->call($bot);

$sendSticker = new SendSticker;
$sendSticker->chatId = $chat;
$sendSticker->sticker = 'CAACAgQAAxkBAAIDVV5rwjTSxLBp55dcGPanK544jA0eAAISAAOKPJcrPzhHw6OsBroYBA';

$sendSticker->call($bot);

$sendAnimation = new SendAnimation;
$sendAnimation->chatId = $chat;
$sendAnimation->animation = 'https://media.giphy.com/media/S5hi5uQZ7Tc5I2coHd/giphy.gif';
$sendAnimation->call($bot);

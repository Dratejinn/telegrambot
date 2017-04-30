<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/vendor/autoload.php';

use Method\SendMessage;
use Telegram\API\Base\InputFile;

$token = '';
$chat = 0;

$bot = new Bot($token);

//CA-certfile config is optional, provide this if the curl CAINFO property should be set to something else than default
// API\ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');

$pieces = $argv;
array_shift($pieces);
$message  = implode(' ', $pieces);

$sendMessage = new Method\SendMessage;
$sendMessage->chatId = $chat;
$sendMessage->text = $message;
$res = $sendMessage->call($bot);

$sendLocation = new Method\SendVenue;
$sendLocation->chatId = $chat;
$sendLocation->latitude = 52.315201;
$sendLocation->longitude = 4.691760;
$sendLocation->title = 'theFrontDoor';
$sendLocation->address = 'Bijlmermeerstraat 70';

$result = $sendLocation->call($bot);

var_dump($result);

$sendChatAction = new Method\SendChatAction;
$sendChatAction->chatId = $chat;
$sendChatAction->action = Method\SendChatAction::ACTION_UPLOAD_AUDIO;
$sendChatAction->call($bot);

$sendAudio = new Method\SendAudio;
$inputFile = new InputFile('nicesong.mp3');

$sendAudio->audio = $inputFile;
$sendAudio->chatId = $chat;
$sendAudio->call($bot);

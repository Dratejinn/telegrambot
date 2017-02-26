<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/vendor/autoload.php';

use Method\SendMessage;
use Telegram\API\Base\InputFile;

// $tostibot = '267010470:AAGNj6z9KQDDGKei4qd_noOHC384dD0oJ6M';
$devToken = '245725233:AAFghNdVDc-E6mwu2HOaYKgmmu3SF0RvLyM';
$tfdDev = -194668408;

$bot = new Bot($devToken);
// $sendMessage()

ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');

$pieces = $argv;
array_shift($pieces);
$message  = implode(' ', $pieces);

// $sendMessage = new Method\SendMessage;
// $sendMessage->chatId = $tfdDev;
// $sendMessage->text = $message;
// $res = $sendMessage->call($bot);
// var_dump($res);

// $sendVideo = new Method\SendDocument;
// $inputFile = new InputFile('wazaa.mov');

// $sendVideo->document = $inputFile;
// // $sendVideo->duration = 2;
// // $sendVideo->width = 480;
// // $sendVideo->height = 480;
// $sendVideo->chatId = $tfdDev;

// $result = $sendVideo->call($bot);

// var_dump($result);

// $sendLocation = new Method\SendVenue;
// $sendLocation->chatId = $tfdDev;
// $sendLocation->latitude = 52.315201;
// $sendLocation->longitude = 4.691760;
// $sendLocation->title = 'theFrontDoor';
// $sendLocation->address = 'Bijlmermeerstraat 70';

// $result = $sendLocation->call($bot);

// var_dump($result);

$sendChatAction = new Method\SendChatAction;
$sendChatAction->chatId = $tfdDev;
$sendChatAction->action = Method\SendChatAction::ACTION_UPLOAD_AUDIO;
$sendChatAction->call($bot);

$sendAudio = new Method\SendAudio;
$inputFile = new InputFile('nicesong.mp3');

$sendAudio->audio = $inputFile;
$sendAudio->chatId = $tfdDev;
sleep(5);
$sendAudio->call($bot);

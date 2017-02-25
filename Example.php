<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/API/Include.php.inc';

use Method\SendMessage;

// $tostibot = '267010470:AAGNj6z9KQDDGKei4qd_noOHC384dD0oJ6M';
$devToken = '245725233:AAFghNdVDc-E6mwu2HOaYKgmmu3SF0RvLyM';
$tfdDev = -194668408;

$bot = new Bot($devToken);
// $sendMessage()

ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');

$pieces = $argv;
array_shift($pieces);
$message  = implode(' ', $pieces);

$sendMessage = new Method\SendMessage;
$sendMessage->chatId = $tfdDev;
$sendMessage->text = $message;
$res = $sendMessage->call($bot);
var_dump($res);

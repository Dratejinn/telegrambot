<?php

declare(strict_types = 1);

namespace Telegram\API;

require_once __DIR__ . '/../vendor/autoload.php';

use \Telegram\API\Method\{SetWebhook, DeleteWebhook, GetWebhookInfo};
use \Telegram\API\Bot;
$token = '';

$bot = new Bot($token);

$setWebhook = new SetWebhook;
$setWebhook->url = 'https://this.isafake.webhook';

var_dump($setWebhook->call($bot));

$getWebhookInfo = new GetWebhookInfo;
var_dump($getWebhookInfo->call($bot));

$deleteWebhook = new DeleteWebhook;
var_dump($deleteWebhook->call($bot));

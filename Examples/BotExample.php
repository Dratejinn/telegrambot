<?php

declare(strict_types = 1);

namespace Examples\Bot;

use Telegram\API;

require_once __DIR__ . '/../vendor/autoload.php';

//CA-certfile config is optional, provide this if the curl CAINFO property should be set to something else than default
// API\ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');

$bot = new ExampleBot;

$bot->run();

<?php

declare(strict_types = 1);

namespace Examples\Bot;

use Telegram\API;
use Telegram\API\ConfigManager;
require_once __DIR__ . '/../vendor/autoload.php';

define('DEVELOPMENT_MODE', TRUE);

API\ConfigManager::AddConfigFromINIFile(__DIR__ . '/Log.ini', 'Log');
//CA-certfile config is optional, provide this if the curl CAINFO property should be set to something else than default
// API\ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');
ConfigManager::AddConfigFromINIFile(__DIR__ . '/../Tokens.ini', 'token');
$tokens = ConfigManager::GetConfig('token');
var_dump($tokens);
$token = $tokens['devbot']['token'];
$bot = new ExampleBot($token);

$bot->run();

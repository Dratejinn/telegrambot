<?php

declare(strict_types = 1);

namespace Examples\Bot;

use Telegram\API;
use Telegram\API\ConfigManager;
use Telegram\Storage\PDO\ConnectionDetails\ConnectionDetailsMySQL;
use Telegram\Storage\PDO\MySQLHandler;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/userCreds.php')) {
    require_once __DIR__ . '/userCreds.php';
    $userCreds = mysqlUserCreds();
} else {
    $userCreds = NULL;
}


define('DEVELOPMENT_MODE', TRUE);

API\ConfigManager::AddConfigFromINIFile(__DIR__ . '/Log.ini', 'Log');
//CA-certfile config is optional, provide this if the curl CAINFO property should be set to something else than default
// API\ConfigManager::AddConfig('CA-certfile', __DIR__ . '/cacert.pem');
ConfigManager::AddConfigFromINIFile(__DIR__ . '/../Tokens.ini', 'token');
$tokens = ConfigManager::GetConfig('token');
$token = $tokens['devbot']['token'];

$emailAddress = 'some@address.com';

$bot = new ExampleBot($token, $emailAddress);
if ($userCreds) {
    $connectionDetails = new ConnectionDetailsMySQL;
    $mysqlHandler = new MySQLHandler($connectionDetails, $userCreds, 'telegrambot');
    $bot->setStorageHandler($mysqlHandler);
}

$logger = new \Monolog\Logger('Logger');
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

$bot->setLogger($logger);
API\API::SetLogger($logger);
$bot->run();

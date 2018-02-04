
# Telegram bot API
[![Code documented](https://codedocs.xyz/Dratejinn/telegrambot.svg)](https://codedocs.xyz/Dratejinn/telegrambot/)

A PHP 7.0+ Telegram bot API used to create bots for Telegram. For more information check [Telegrams bot API](https://core.telegram.org/bots/api)

## Base API
The basis of the bot API can be found in [src/API](https://github.com/Dratejinn/telegrambot/tree/master/src/API). The structure reflects telegrams API as much as possible.
### Basic examples
All sendable objects have a `->call(\Telegram\API\Bot $bot)` method which can be used to send the object to the telegram API. Some examples can be found in [Examples/Examples.php](https://github.com/Dratejinn/telegrambot/blob/master/Examples/Example.php)

**sending a chatmessage**
```php
<?php
require_once 'vendor/autoload.php';

use Telegram\API\Bot;
use Telegram\API\Method\SendMessage;

$bot = new Bot('bottoken here');

$sendMessage = new SendMessage;
$sendMessage->chatId = 1234566;
$sendMessage->text = 'Hello world!';
$sendMessage->call($bot);
```
**Sending a photo**
```php
<?php
require_once 'vendor/autoload.php';

use Telegram\API\Bot;
use Telegram\API\Method\SendPhoto;

$bot = new Bot('bottoken here');

$sendPhoto = new SendPhoto;
$sendPhoto->chatId = 1234566;
$sendPhoto->photo = new InputFile('pathToFile');
$sendPhoto->call($bot);
```

## Creating a bot
Creating a bot is very easy. Telegram accepts two type of bots. One where the bot is continuously requesting updates using the getUpdates API call and the other is using WebHooks. Both options are available.

**A simple bot**
The bot
```php
<?php
declare(strict_types = 1);
namespace Examples\Bot;
use Telegram\Bot\ABot as TBot;
class ExampleBot extends TBot {
    const TOKEN = ''; //place your token here (optionally)
    protected $_handlers = [
        self::UPDATE_TYPE_MESSAGE => Handlers\MessageHandler::class
    ];
    public function __construct(string $token = NULL) {
        if ($token === NULL) {
            $token = self::TOKEN;
        }
        parent::__construct($token);
    }
}
```
Message handler
```php
<?php
declare(strict_types = 1);
namespace Examples\Bot\Handlers;
use Telegram\Bot\Handler\AMessageHandler;
class MessageHandler extends AMessageHandler {
    protected $_commandHandlers = [
        Command\ExampleCommandHandler::class,
    ];
    public function handleText(string $text) {
        $this->sendTextMessage('You typed: ' . $text);
    }
}
```
Command handler
```php
<?php
declare(strict_types = 1);
namespace Examples\Bot\Handlers\Command;
use Telegram\Bot\Handler\ACommandHandler;
class ExampleCommandHandler extends ACommandHandler {
    
    public function handleCommand(string $command) {
        $this->sendTextMessage('You fired the command: ' . $command);
        $this->sendTextMessage('Provided with arguments: ' . implode(' ', $this->getArguments()));
    }
    public static function GetRespondsTo() : array {
        return [
            'test',
            'example'
        ];
    }
}
```

### Running the bot with continuous polling
```php
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
ConfigManager::AddConfigFromINIFile(__DIR__ . '/../Tokens.ini', 'token');
$tokens = ConfigManager::GetConfig('token');
$token = $tokens['devbot']['token'];
$bot = new ExampleBot($token);
if ($userCreds) {
    $connectionDetails = new ConnectionDetailsMySQL;
    $mysqlHandler = new MySQLHandler($connectionDetails, $userCreds, 'telegrambot');
    $bot->setStorageHandler($mysqlHandler);
}
$bot->run();
```

### Running the bot using webhooks
```php
<?php

use Examples\Bot\ExampleBot;
use Telegram\API\Type\Update;

require_once __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents('php://input');
if ($input) {
	$bot = new ExampleBot('tokenHere');
	$update = json_decode($input);
	$updateObj = new Update($update);
	$bot->handleUpdate($update);
}
```

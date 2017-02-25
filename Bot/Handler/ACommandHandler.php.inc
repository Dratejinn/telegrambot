<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\API\Method\SendMessage;

abstract class ACommandHandler extends \Telegram\Bot\AHandler {

    public function handle() {
        throw new \Exception('This method should not be invoked!');
    }

    abstract public function handleCommand(string $command);
    abstract public static function GetRespondsTo();
}

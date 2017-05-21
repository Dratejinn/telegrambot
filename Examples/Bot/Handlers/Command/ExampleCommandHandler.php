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

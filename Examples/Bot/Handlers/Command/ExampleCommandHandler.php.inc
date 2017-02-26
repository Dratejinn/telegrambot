<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers\Command;

use Telegram\Bot\Handler\ACommandHandler;

class ExampleCommandHandler extends ACommandHandler {
    
    public function handleCommand(string $command) {
        $this->sendTextMessage('You fired the command: ' . $command);
    }

    public static function GetRespondsTo() {
        return [
            'test',
            'example'
        ];
    }
} 

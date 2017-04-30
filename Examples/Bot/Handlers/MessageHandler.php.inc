<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers;

use Telegram\Bot\Handler\AMessageHandler;

class MessageHandler extends AMessageHandler {

    protected $_commandHandlers = [
        Command\ExampleCommandHandler::class,
    ];

    public function handleText(string $text) {
        $this->sendTextMessage('You typed in the text: ' . $text);
    }
}

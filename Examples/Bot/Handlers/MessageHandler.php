<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers;

use Telegram\Bot\Handler\AMessageHandler;
use Telegram\Bot\Handler\Command\NoDataStoredPrivacyPolicyHandler;

class MessageHandler extends AMessageHandler {

    protected array $_commandHandlers = [
        Command\ExampleCommandHandler::class,
        Command\PollCommandHandler::class
    ];

    public function handleText(string $text) {
        $this->sendTextMessage('You typed in the text: ' . $text);
    }

    protected function _getPrivacyCommandHandler() : string {
        return NoDataStoredPrivacyPolicyHandler::class;
    }


}

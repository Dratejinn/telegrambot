<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers;

use Telegram\Bot\Handler\APollHandler;

class PollHandler extends APollHandler {

    public function handle() {
        $this->_message->replyToMessage('Hoi!');
    }
}

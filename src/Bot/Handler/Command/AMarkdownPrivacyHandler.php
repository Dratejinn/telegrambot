<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler\Command;

use Telegram\API\Method\SendMessage;

abstract class AMarkdownPrivacyHandler extends APrivacyCommandHandler {

    protected function _getPrivacyPolicySendMessage() : SendMessage {
        $sendMessage = $this->createSendMessage();

        $text = file_get_contents($this->_getMarkdownContentPath());

        $bot = $this->_bot->getMe();
        $emailAddress = $this->getEmailAddress();

        $text = str_replace(['%botname%', '%emailaddress%'], [$bot->username, $emailAddress], $text);

        $sendMessage->text = $text;
        $sendMessage->parseMode = SendMessage::PARSEMODE_MARKDOWN;

        return $sendMessage;
    }

    abstract protected function _getMarkdownContentPath() : string;

}

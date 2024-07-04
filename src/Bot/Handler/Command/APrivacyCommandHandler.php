<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler\Command;

use Telegram\API\Method\SendMessage;
use Telegram\Bot\Handler\ACommandHandler;

abstract class APrivacyCommandHandler extends ACommandHandler {

    public function handleCommand(string $command) {
        $sendMessage = $this->_getPrivacyPolicySendMessage();
        $this->sendMessage($sendMessage);
    }

    abstract protected function _getPrivacyPolicySendMessage() : SendMessage;

    public function getEmailAddress() : string {
        return $this->_bot->getPrivacyPolicyEmailAddress();
    }

    public static function GetRespondsTo() : array {
        return ['privacy'];
    }

    public static function ShouldPublishCommand(string $command) : bool {
        return TRUE;
    }

    public static function GetDescriptionForCommand(string $command) : string {
        return 'Returns the privacy policy of this bot.';
    }


}

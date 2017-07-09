<?php

namespace Telegram\Bot;

use Telegram\API;

use Telegram\API\Method\SendMessage;
use Monolog\Logger;
use Telegram\LogHelpers;
use Telegram\Storage\Interfaces\IStorageHandlerAware;
use Telegram\Storage\Traits\TStorageHandlerTrait;

abstract class AHandler implements LogHelpers\Interfaces\ILoggerAwareInterface, IStorageHandlerAware {

    use LogHelpers\Traits\TLoggerTrait;
    use TStorageHandlerTrait;

    protected $_type        = NULL;
    protected $_update      = NULL;
    protected $_bot         = NULL;
    protected $_apiBot      = NULL;

    protected $_message     = NULL;

    public function __construct(API\Type\Update $update, ABot $bot) {
        $this->_type = $update->getType();
        $this->_update = $update;
        $this->_bot = $bot;
        $this->_apiBot = $bot->getBot();

        switch ($this->_type) {
            case 'message':
            case 'editedMessage':
            case 'channelPost':
            case 'editedChannelPost':
                $this->_message = $this->_update->{$this->_type};
                break;
            case 'callbackQuery':
                if (isset($this->_update->{$this->_type}->message)) {
                    $this->_message = $this->_update->{$this->_type}->message;
                }
        }
    }

    public function createSendMessage() : SendMessage {
        $sendMessage = new SendMessage;
        if ($this->_message !== NULL) {
            $sendMessage->chatId = $this->_message->chat->id;
        }
        return $sendMessage;
    }

    public function sendMessage(SendMessage $message) {
        return $message->call($this->_apiBot);
    }

    public function sendTextMessage(string $text) {
        if ($this->_message) {
            $sendMessage = new SendMessage;
            $sendMessage->chatId = $this->_message->chat->id;
            $sendMessage->text = $text;
            return $this->sendMessage($sendMessage);
        }
    }

    public function getLoggerContext() : array {
        return $this->_bot->getLoggerContext();
    }

    public function getLanguageCode() {
        if ($this->_message !== NULL) {
            return $this->_message->from->languageCode;
        }
        return NULL;
    }

    abstract public function handle();
}

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

    /**
     * The update type
     * @var string
     */
    protected $_type        = NULL;

    /**
     * the update that needs to be handled
     * @var \Telegram\API\Type\Update
     */
    protected $_update      = NULL;

    /**
     * the bot where the handle call originated from
     * @var \Telegram\Bot\ABot
     */
    protected $_bot         = NULL;

    /**
     * the api bot
     * @var \Telegram\API\Bot
     */
    protected $_apiBot      = NULL;

    /**
     * Optional message from the update
     * @var null|\Telegram\API\Type\Message
     */
    protected $_message     = NULL;

    /**
     * AHandler constructor.
     * @param \Telegram\API\Type\Update $update
     * @param \Telegram\Bot\ABot $bot
     */
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

    /**
     * Creates a sendMessage object. If there was a message available from the update, the sendMessage will have its chatId set to the corresponding chat
     * @return \Telegram\API\Method\SendMessage
     */
    public function createSendMessage() : SendMessage {
        $sendMessage = new SendMessage;
        if ($this->_message !== NULL) {
            $sendMessage->chatId = $this->_message->chat->id;
        }
        return $sendMessage;
    }

    /**
     * Sends a sendMessage object using the apiBot. Returns the result of SendMessage->call
     * @param \Telegram\API\Method\SendMessage $message
     * @return \Telegram\API\Type\Message
     */
    public function sendMessage(SendMessage $message) {
        return $message->call($this->_apiBot);
    }

    /**
     * @param string $text
     * @return \Telegram\API\Type\Message
     */
    public function sendTextMessage(string $text) {
        if ($this->_message) {
            $sendMessage = new SendMessage;
            $sendMessage->chatId = $this->_message->chat->id;
            $sendMessage->text = $text;
            return $this->sendMessage($sendMessage);
        }
    }

    /**
     * Used to get the loggercontext from the bot
     * @return array
     */
    public function getLoggerContext() : array {
        return $this->_bot->getLoggerContext();
    }

    /**
     * If there is a message available from the update, this method will return the language code of the user where the message originated from
     * @return null|string
     */
    public function getLanguageCode() {
        if ($this->_message !== NULL) {
            return $this->_message->from->languageCode;
        }
        return NULL;
    }

    /**
     * To be implemented by the extending class. This method is called from the bot
     * @return mixed
     */
    abstract public function handle();
}

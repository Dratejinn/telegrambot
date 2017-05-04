<?php

declare(strict_types = 1);

namespace Telegram\Bot;

use Telegram\API;
use Telegram\API\Method\GetUpdates;
use Telegram\API\Type\User;
use Telegram\Bot\Handler\{AMessageHandler};
use Telegram\LogHelpers;

abstract class ABot implements LogHelpers\Interfaces\ILoggerAwareInterface {

    use LogHelpers\Traits\TLoggerTrait;

    const UPDATE_TYPE_MESSAGE               = 'message';
    const UPDATE_TYPE_EDITEDMESSAGE         = 'editedMessage';
    const UPDATE_TYPE_CHANNELPOST           = 'channelPost';
    const UPDATE_TYPE_EDITEDCHANNELPOST     = 'editedChannelPost';
    const UPDATE_TYPE_INLINEQUERY           = 'inlineQuery';
    const UPDATE_TYPE_CHOSENINLINERESULT    = 'chosenInlineResult';
    const UPDATE_TYPE_CALLBACKQUERY         = 'callbackQuery';

    protected $_bot         = NULL;
    protected $_me          = NULL;
    private $_updateHandler = NULL;

    protected $_handlers    = [];

    protected $_chats = [];

    public function __construct(string $token = NULL) {
        //initialize APIbot
        $this->_bot = new API\Bot($token);
        $this->_updateHandler = new GetUpdates;
        $this->_me = $this->_bot->getMe();
    }

    public function __invoke(string $token = NULL) {
        return new static($token);
    }

    public function setHandler(string $handlerClass, string $handlerType) {
        if ($this->_isValidHandler($handlerClass, $handlerType)) {
            $this->_handlers[$handlerType] = $handlerClass;
        }
    }

    public function getMe() : User {
        return $this->_me;
    }

    public function getUsername() : string {
        return $this->_me->getUsername();
    }

    public function run() {
        while (TRUE) {
            $this->_handleUpdates();
            sleep(1);
        }
    }

    protected function _handleUpdates() {
        $updates = $this->_updateHandler->call($this->_bot);
        if (!empty($updates)) {
            foreach ($updates as $update) {
                $this->_updateHandler->offset = $update->id + 1;
                $updateType = $update->getType();
                switch ($updateType) {
                    case 'message':
                    case 'editedMessage':
                    case 'channelPost':
                    case 'editedChannelPost':
                        if (isset($update->message->leftChatMember)) {
                            if ($this->_me->id === $update->message->leftChatMember->id) {
                                $this->logInfo('Removing chat with id:' . $update->message->chat->id . ' from current chatlist!', $this->getLoggerContext());
                                unset($this->_chats[$update->message->chat->id]);
                            }
                        } elseif (!isset($this->_chats[$update->message->chat->id])) {
                            $this->logInfo('Adding chat with id:' . $update->message->chat->id, $this->getLoggerContext());
                            $this->_chats[$update->message->chat->id] = $update->message->chat;
                        }
                        //fallthrough intended
                    case 'inlineQuery':
                    case 'chosenInlineResult':
                    case 'callbackQuery':
                        if (isset($this->_handlers[$updateType])) {
                            $handler = new $this->_handlers[$updateType]($update, $this);
                            $handler->handle();
                        }
                        break;
                }
            }
        }
    }

    public function getBot() : API\Bot {
        return $this->_bot;
    }

    public function getChats() : array {
        return $this->_chats;
    }

    public function getChatById(int $id) {
        if (isset($this->_chats[$id])) {
            return $this->_chats[$id];
        }
    }

    protected function _isValidHandler(string $className, string $handlerType) : bool {
        switch ($handlerType) {
            case 'message':
            case 'editedMessage':
            case 'channelPost':
            case 'editedChannelPost':
                $handlerClass = AMessageHandler::class;
                break;
            case 'inlineQuery':
                $handlerClass = AInlineQueryHandler::class;
                break;
            case 'chosenInlineResult':
                $handlerClass = AChosenInlineResultHandler::class;
                break;
            case 'callbackQuery':
                $handlerClass = ACallbackQueryHandler::class;
                break;
            default:
                return FALSE;
        }
        return class_exists($className) && is_a($className, $handlerClass, TRUE);
    }

    public function getLoggerContext() : array {
        return $this->_bot->getLoggerContext();
    }

}

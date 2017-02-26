<?php

declare(strict_types = 1);

namespace Telegram\Bot;

use Telegram\API;
use Telegram\API\Method\{GetUpdates, GetMe};
use Telegram\Bot\Handler\{AMessageHandler};

abstract class ABot {

    const UPDATE_TYPE_MESSAGE               = 'message';
    const UPDATE_TYPE_EDITEDMESSAGE         = 'editedMessage';
    const UPDATE_TYPE_CHANNELPOST           = 'channelPost';
    const UPDATE_TYPE_EDITEDCHANNELPOST     = 'editedChannelPost';
    const UPDATE_TYPE_INLINEQUERY           = 'inlineQuery';
    const UPDATE_TYPE_CHOSENINLINERESULT    = 'chosenInlineResult';
    const UPDATE_TYPE_CALLBACKQUERY         = 'callbackQuery';

    protected $_bot         = NULL;
    private $_updateHandler = NULL;

    protected $_handlers    = [];

    protected $_chats = [];

    public function __construct(string $token = NULL) {
        //initialize APIbot
        $this->_bot = new API\Bot($token);
        $this->_updateHandler = new GetUpdates;
    }

    public function setHandler(string $handlerCLass, string $handlerType) {
        if ($this->_isValidHandler($handlerClass, $handlerType)) {
            $this->_handlers[$handlerType] = $handlerClass;
        }
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
                            $getMe = new GetMe;
                            $me = $getMe->call($this->_bot);
                            if ($me->id === $update->message->leftChatMember->id) {
                                unset($this->_chats[$update->message->chat->id]);
                            }
                        } elseif (!isset($this->_chats[$update->message->chat->id])) {
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
        switch($handlerType) {
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

}

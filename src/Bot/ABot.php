<?php

declare(strict_types = 1);

namespace Telegram\Bot;

use Telegram\API;
use Telegram\API\Method\GetUpdates;
use Telegram\API\Type\{User, Update, Chat};
use Telegram\Bot\Handler\{AMessageHandler};
use Telegram\LogHelpers;
use Telegram\Storage\Interfaces\{ITelegramStorageHandler, IStorageHandlerAware};
use Telegram\Storage\Traits\TStorageHandlerTrait;

use Psr\Log;

abstract class ABot implements LogHelpers\Interfaces\ILoggerAwareInterface, IStorageHandlerAware {

    use LogHelpers\Traits\TLoggerTrait;
    use TStorageHandlerTrait;

    const UPDATE_TYPE_MESSAGE               = 'message';
    const UPDATE_TYPE_EDITEDMESSAGE         = 'editedMessage';
    const UPDATE_TYPE_CHANNELPOST           = 'channelPost';
    const UPDATE_TYPE_EDITEDCHANNELPOST     = 'editedChannelPost';
    const UPDATE_TYPE_INLINEQUERY           = 'inlineQuery';
    const UPDATE_TYPE_CHOSENINLINERESULT    = 'chosenInlineResult';
    const UPDATE_TYPE_CALLBACKQUERY         = 'callbackQuery';
    const UPDATE_TYPE_SHIPPINGQUERY         = 'shippingQuery';
    const UPDATE_TYPE_PRECHECKOUTQUERY      = 'preCheckoutQuery';

    const GETUPDATES_SLEEP_INTERVAL = 1; //seconds
    const RUN_ERROR_TIMEOUT = 60; //seconds


    protected $_bot             = NULL;
    protected $_me              = NULL;
    private $_updateHandler     = NULL;

    protected $_handlers        = [];

    protected $_chats           = [];

    private $_joinChatHandlers  = [];

    private $_leaveChatHandlers = [];

    private $_initialized       = FALSE;

    public function __construct(string $token = NULL, ITelegramStorageHandler $storageHandler = NULL) {
        //initialize APIbot
        $this->_bot = new API\Bot($token);
        $this->_updateHandler = new GetUpdates;
        $this->_me = $this->_bot->getMe();
        if ($storageHandler) {
            $this->setStorageHandler($storageHandler);
            $this->init();
        }
    }

    public function init() {
        $this->logDebug('Initializing!', $this->getLoggerContext());
        //if the chatlist is empty and we have a storage handler, load all chats from the storage handler
        if ($this->hasStorageHandler() && empty($this->_chats)) {
            $chats = $this->loadAll(Chat::class);
            foreach ($chats as $chat) {
                if (!$chat instanceof Chat) {
                    throw new \LogicException('retrieval of chats went wrong! Chat is not an instance of Telegram\\API\\Type\\Chat!');
                }
                $this->_chats[$chat->id] = $chat;
            }
        }
    }

    public function __invoke(string $token = NULL) {
        return new static($token);
    }

    public function setHandler(string $handlerClass, string $handlerType) {
        if ($this->_isValidHandler($handlerClass, $handlerType)) {
            $this->_handlers[$handlerType] = $handlerClass;
        }
    }

    public function addJoinChatHandler(string $name, callable $callback) {
        $this->_joinChatHandlers[$name] = $callback;
    }

    public function removeJoinChatHandler(string $name) {
        unset($this->_joinChatHandlers[$name]);
    }

    public function addLeaveChatHandler(string $name, callable $callback) {
        $this->_leaveChatHandlers[$name] = $callback;
    }

    public function removeLeaveChatHandler(string $name) {
        unset($this->_leaveChatHandlers[$name]);
    }

    public function getMe() : User {
        return $this->_me;
    }

    public function getUsername() : string {
        return $this->_me->getUsername();
    }

    public function run(bool $throwOnFailure = TRUE) {
        while (TRUE) {
            try {
                $updates = $this->getUpdates();
                $this->handleUpdates($updates);
            } catch (\Throwable $e) {
                if ($throwOnFailure) {
                    throw $e;
                } else {
                    $this->logError((string) $e, $this->getLoggerContext());
                    if (static::RUN_ERROR_TIMEOUT > 0) {
                        sleep(static::RUN_ERROR_TIMEOUT);
                    }
                }
            }
            if (static::GETUPDATES_SLEEP_INTERVAL > 0) {
                sleep(static::GETUPDATES_SLEEP_INTERVAL);
            }
        }
    }

    public function getUpdates() : array {
        return $this->_updateHandler->call($this->_bot);
    }

    public function handleUpdates(array $updates) {
        if (!empty($updates)) {
            foreach ($updates as $update) {
                $this->handleUpdate($update);
            }
        }
    }

    public function handleUpdate(Update $update) {
        $this->_updateHandler->offset = $update->id + 1;
        $updateType = $update->getType();
        switch ($updateType) {
            case static::UPDATE_TYPE_MESSAGE:
            case static::UPDATE_TYPE_EDITEDMESSAGE:
            case static::UPDATE_TYPE_CHANNELPOST:
            case static::UPDATE_TYPE_EDITEDCHANNELPOST:
                $updateType = $update->getType();
                if (isset($update->{$updateType}->leftChatMember)) {
                    if ($this->_me->id === $update->{$updateType}->leftChatMember->id) {
                        $this->logInfo('Removing chat with id: ' . $update->{$updateType}->chat->id . ' from current chatlist!', $this->getLoggerContext());
                        $this->delete($update->{$updateType}->chat);
                        unset($this->_chats[$update->{$updateType}->chat->id]);
                        foreach ($this->_leaveChatHandlers as $name => $callable) {
                            $callable($name, $update->{$updateType}->chat, $update->{$updateType});
                        }
                    }
                } elseif (!isset($this->_chats[$update->{$updateType}->chat->id])) {
                    $this->logInfo('Adding chat with id: ' . $update->{$updateType}->chat->id, $this->getLoggerContext());
                    $this->store($update->{$updateType}->chat);
                    $this->_chats[$update->{$updateType}->chat->id] = $update->{$updateType}->chat;
                    foreach ($this->_joinChatHandlers as $name => $callable) {
                        $callable($name, $update->{$updateType}->chat, $update->{$updateType});
                    }
                }
                //fallthrough intended
            case static::UPDATE_TYPE_INLINEQUERY:
            case static::UPDATE_TYPE_CHOSENINLINERESULT:
            case static::UPDATE_TYPE_CALLBACKQUERY:
            case static::UPDATE_TYPE_SHIPPINGQUERY:
            case static::UPDATE_TYPE_PRECHECKOUTQUERY:
                if (isset($this->_handlers[$updateType])) {
                    $handler = new $this->_handlers[$updateType]($update, $this);
                    if ($this->hasLogger()) {
                        $handler->setLogger($this->getLogger());
                    }
                    if ($this->hasStorageHandler()) {
                        $handler->setStorageHandler($this->getStorageHandler());
                    }
                    $handler->handle();
                }
                break;
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

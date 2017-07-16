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


    /**
     * @var null|\Telegram\API\Bot
     */
    protected $_bot             = NULL;

    /**
     * @var null|\Telegram\API\Type\User
     */
    protected $_me              = NULL;

    /**
     * @var null|\Telegram\API\Method\GetUpdates
     */
    private $_updateHandler     = NULL;

    /**
     * @var \Telegram\Bot\AHandler[]
     */
    protected $_handlers        = [];

    /**
     * @var \Telegram\API\Type\Chat[]
     */
    protected $_chats           = [];

    /**
     * @var callable[]
     */
    private $_joinChatHandlers  = [];

    /**
     * @var callable[]
     */
    private $_leaveChatHandlers = [];

    /**
     * ABot constructor.
     * @param string|NULL $token
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler|NULL $storageHandler
     */
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

    /**
     * After constructing a bot it is optional to call init to load any Chats from the provided storage handler.
     * This is also called internally when constructing a bot with a storage handler
     */
    public function init() {
        $this->logDebug('Initializing!', $this->getLoggerContext());
        //if the chatlist is empty and we have a storage handler, load all chats from the storage handler
        if ($this->hasStorageHandler() && empty($this->_chats)) {
            $chats = $this->loadAll(Chat::class);
            foreach ($chats as $chat) {
                if (!$chat instanceof Chat) {
                    throw new \LogicException('retrieval of chats went wrong! Chat is not an instance of Telegram\\API\\Type\\Chat!');
                }
                $this->_chats[(string) $chat->id] = $chat;
            }
        }
    }

    /**
     * Used to add an update handler to the bot.
     * @param string $handlerClass
     * @param string $handlerType
     */
    public function setHandler(string $handlerClass, string $handlerType) {
        if ($this->_isValidHandler($handlerClass, $handlerType)) {
            $this->_handlers[$handlerType] = $handlerClass;
        }
    }

    /**
     * Used to add a JoinChatHandler. This callable will be called after the bot has joined a new chat.
     * The callable gets the following arguments: string $name, \Telegram\API\Type\Chat $chat, string $updateType.
     *
     * @param string $name
     * @param callable $callback
     */
    public function addJoinChatHandler(string $name, callable $callback) {
        $this->_joinChatHandlers[$name] = $callback;
    }

    /**
     * Used to remove a JoinChatHandler with the provided name
     * @param string $name
     */
    public function removeJoinChatHandler(string $name) {
        unset($this->_joinChatHandlers[$name]);
    }

    /**
     * Used to add an LeaveChatHandler. This callable will be called after the bot has left a known chat.
     * The callable gets the following arguments: string $name, \Telegram\API\Type\Chat $chat, string $updateType.
     *
     * @param string $name
     * @param callable $callback
     */
    public function addLeaveChatHandler(string $name, callable $callback) {
        $this->_leaveChatHandlers[$name] = $callback;
    }

    /**
     * Used to remove a LeaveChatHandler with the provided name
     * @param string $name
     */
    public function removeLeaveChatHandler(string $name) {
        unset($this->_leaveChatHandlers[$name]);
    }

    /**
     * Return the Bot user object
     * @return \Telegram\API\Type\User
     */
    public function getMe() : User {
        return $this->_me;
    }

    /**
     * Get this bots username
     * @return string
     */
    public function getUsername() : string {
        return $this->_me->getUsername();
    }

    /**
     * Call this method to run this bot other ways to run this bot are using getUpdates and handleUpdates
     * @param bool $throwOnFailure
     * @throws \Throwable
     */
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

    /**
     * Use this method to get new updates
     * @return array
     */
    public function getUpdates() : array {
        return $this->_updateHandler->call($this->_bot);
    }

    /**
     * Handles an array of updates
     * @param array $updates
     */
    public function handleUpdates(array $updates) {
        if (!empty($updates)) {
            foreach ($updates as $update) {
                $this->handleUpdate($update);
            }
        }
    }

    /**
     * Handle an incomming update.
     * Calls the respective Update handler if its provided
     * @param \Telegram\API\Type\Update $update
     */
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
                        unset($this->_chats[(string) $update->{$updateType}->chat->id]);
                        foreach ($this->_leaveChatHandlers as $name => $callable) {
                            $callable($name, $update->{$updateType}->chat, $update->{$updateType});
                        }
                    }
                } elseif (!isset($this->_chats[(string) $update->{$updateType}->chat->id])) {
                    $this->logInfo('Adding chat with id: ' . $update->{$updateType}->chat->id, $this->getLoggerContext());
                    $this->store($update->{$updateType}->chat);
                    $this->_chats[(string) $update->{$updateType}->chat->id] = $update->{$updateType}->chat;
                    foreach ($this->_joinChatHandlers as $name => $callable) {
                        $callable($name, $update->{$updateType}->chat, $update->{$updateType});
                    }
                } else {
                    //check if we should update the chat in storage
                    $storedInfo = $this->load(Chat::class, (string) $update->{$updateType}->chat->id);
                    if ($storedInfo instanceof Chat) {
                        $this->logDebug('Found Stored info');
                        if (!$update->{$updateType}->chat->isEqual($storedInfo)) {
                            $this->logInfo('Updating chat with id: ' . $update->{$updateType}->chat->id, $this->getLoggerContext());
                            $this->store($update->{$updateType}->chat);
                        }
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
                } else {
                    $this->logAlert('Warning no suitable handler found for type: ' . $updateType);
                }
                break;
        }
    }

    /**
     * Get the api bot
     * @return \Telegram\API\Bot
     */
    public function getBot() : API\Bot {
        return $this->_bot;
    }

    /**
     * Get all Chats this bot is in
     * @return \Telegram\API\Type\Chat[]
     */
    public function getChats() : array {
        return $this->_chats;
    }

    /**
     * Get a Chat by id. Returns NULL if no chat with id is found
     * @param string $id
     * @return \Telegram\API\Type\Chat|null
     */
    public function getChatById(string $id) {
        if (isset($this->_chats[$id])) {
            return $this->_chats[$id];
        }
        return NULL;
    }

    /**
     * Used to send provided SendMessage to all chats available to this bot
     * @param \Telegram\API\Method\SendMessage $sendMessage
     */
    public function sendMessageToAllChats(API\Method\SendMessage $sendMessage) {
        foreach ($this->getChats() as $chat) {
            $sendMessage->chatId = $chat->id;
            $sendMessage->call($this->_bot);
        }
    }

    /**
     * Used to check if the provided classname is a valid update handler
     * @param string $className
     * @param string $handlerType
     * @return bool
     */
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

    /**
     * Used to get the bots logger context
     * @return array
     */
    public function getLoggerContext() : array {
        return $this->_bot->getLoggerContext();
    }
}

<?php

declare(strict_types = 1);

namespace Telegram\Bot;

use Telegram\API;
use Telegram\API\Method\GetUpdates;
use Telegram\API\Type\{User, Update, Chat};
use Telegram\Bot\Handler\{
    ACallbackQueryHandler, AChosenInlineResultHandler, AInlineQueryHandler, AMessageHandler, APollAnswerHandler, APollHandler
};
use Telegram\LogHelpers;
use Telegram\Storage\Interfaces\{ITelegramStorageHandler, IStorageHandlerAware};
use Telegram\Storage\Traits\TStorageHandlerTrait;

abstract class ABot implements LogHelpers\Interfaces\ILoggerAwareInterface, IStorageHandlerAware {

    use LogHelpers\Traits\TLoggerTrait;
    use TStorageHandlerTrait;

    public const UPDATE_TYPE_MESSAGE               = 'message';
    public const UPDATE_TYPE_EDITEDMESSAGE         = 'editedMessage';
    public const UPDATE_TYPE_CHANNELPOST           = 'channelPost';
    public const UPDATE_TYPE_EDITEDCHANNELPOST     = 'editedChannelPost';
    public const UPDATE_TYPE_INLINEQUERY           = 'inlineQuery';
    public const UPDATE_TYPE_CHOSENINLINERESULT    = 'chosenInlineResult';
    public const UPDATE_TYPE_CALLBACKQUERY         = 'callbackQuery';
    public const UPDATE_TYPE_SHIPPINGQUERY         = 'shippingQuery';
    public const UPDATE_TYPE_PRECHECKOUTQUERY      = 'preCheckoutQuery';
    public const UPDATE_TYPE_POLL                  = 'poll';
    public const UPDATE_TYPE_POLL_ANSWER           = 'pollAnswer';

    public const GETUPDATES_SLEEP_INTERVAL = 1; //seconds
    public const RUN_ERROR_TIMEOUT = 60; //seconds

    protected ?API\Bot $_bot = NULL;
    protected ?User $_me = NULL;
    protected ?GetUpdates $_updateHandler = NULL;
    protected string $_privacyPolicyEmailAddress;

    /**
     * @var \Telegram\Bot\AHandler[]
     */
    protected array $_handlers = [];

    /**
     * @var \Telegram\API\Type\Chat[]
     */
    protected array $_chats = [];

    /**
     * @var callable[]
     */
    private array $_joinChatHandlers = [];

    /**
     * @var callable[]
     */
    private array $_leaveChatHandlers = [];

    /**
     * @var callable[]
     */
    private array $_memberLeftChatHandlers = [];

    /**
     * @var callable[]
     */
    private array $_membersJoinedChatHandlers = [];

    /**
     * ABot constructor.
     * @param string|NULL $token
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler|NULL $storageHandler
     */
    public function __construct(?string $token, string $privacyPolicyEmailAddress, ?ITelegramStorageHandler $storageHandler = NULL) {
        //initialize APIbot
        $this->_bot = new API\Bot($token);
        $this->_updateHandler = new GetUpdates;
        $this->_me = $this->_bot->getMe();

        $this->_privacyPolicyEmailAddress = $privacyPolicyEmailAddress;

        if ($storageHandler) {
            $this->setStorageHandler($storageHandler);
        }
        $this->init();
    }

    /**
     * After constructing a bot, init will be called. If there as a storagehandler set, this method will retrieve chats from storage in case no chats have been found yet
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
        if (isset($this->_handlers[self::UPDATE_TYPE_MESSAGE])) {
            $dummyUpdate = new Update;
            /** @var AMessageHandler $messageHandler */
            $messageHandler = new $this->_handlers[self::UPDATE_TYPE_MESSAGE]($dummyUpdate, $this);
            $commandHandlers = $messageHandler->getCommandHandlers();

            $commandSet = [];

            foreach ($commandHandlers as $commandHandler) {
                $respondsTo = $commandHandler::GetRespondsTo();
                foreach ($respondsTo as $command) {
                    if ($commandHandler::ShouldPublishCommand($command)) {
                        $botCommand = new API\Type\BotCommand;
                        $botCommand->command = $command;
                        $botCommand->description = $commandHandler::GetDescriptionForCommand($command);
                        $commandSet[] = $botCommand;
                    }
                }
            }

            if (!empty($commandSet)) {
                $setMyCommands = new API\Method\SetMyCommands;
                $setMyCommands->commands = $commandSet;
                $setMyCommands->call($this->_bot);
            }
        }
    }

    public function getPrivacyPolicyEmailAddress() : string {
        return $this->_privacyPolicyEmailAddress;
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
     * The callable gets the following arguments: ABot $bot, string $name Update $update
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
     * The callable gets the following arguments: ABot $bot, string $name Update $update
     *
     * @param string $name
     * @param callable $callback
     */
    public function addLeaveChatHandler(string $name, callable $callback) {
        $this->_leaveChatHandlers[$name] = $callback;
    }

    /**
     * Used to add a memberLeftChatHandler. This callable will be called after a user from a known group has left the chat.
     * The callable gets the following arguments: ABot $bot, string $name Update $update
     *
     * @param string $name
     * @param callable $callback
     */
    public function addMemberLeftChatHandler(string $name, callable  $callback) {
        $this->_memberLeftChatHandlers[$name] = $callback;
    }

    /**
     * Removes a memberLeftChatHandler
     *
     * @param string $name
     */
    public function removeMemberLeftChatHandler(string $name) {
        unset($this->_memberLeftChatHandlers[$name]);
    }

    /**
     * Used to add a membberLeftChatHandler. This callable will be called after a user from a known group has left the chat.
     * The callable gets the following arguments: ABot $bot, string $name Update $update
     *
     * @param string $name
     * @param callable $callback
     */
    public function addMembersJoinedChatHandler(string $name, callable $callback) {
        $this->_membersJoinedChatHandlers[$name] = $callback;
    }

    /**
     * Removes a membersJoinedChatHandler
     *
     * @param string $name
     */
    public function removeMembersJoinedChatHandler(string $name) {
        unset($this->_membersJoinedChatHandlers[$name]);
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
     * @param callable $errorHandler optional errorHandler to do some custom actions when an error occurs
     * @throws \Throwable
     */
    public function run(bool $throwOnFailure = TRUE, callable $errorHandler = NULL) {
        while (TRUE) {
            try {
                $updates = $this->getUpdates();
                $this->handleUpdates($updates);
            } catch (\Throwable $e) {
                if ($errorHandler !== NULL) {
                    $errorHandler($e);
                }
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
                            $callable($this, $name, $update);
                        }
                    } else {
                        foreach ($this->_memberLeftChatHandlers as $name => $callable) {
                            $callable($this, $name, $update);
                        }
                    }
                } elseif (!isset($this->_chats[(string) $update->{$updateType}->chat->id])) {
                    $this->logInfo('Adding chat with id: ' . $update->{$updateType}->chat->id, $this->getLoggerContext());
                    $this->store($update->{$updateType}->chat);
                    $this->_chats[(string) $update->{$updateType}->chat->id] = $update->{$updateType}->chat;
                    foreach ($this->_joinChatHandlers as $name => $callable) {
                        $callable($this, $name, $update);
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
                if (isset($update->{$updateType}->newChatMembers)) {
                    foreach ($this->_membersJoinedChatHandlers as $name => $callable) {
                        $callable($this, $name, $update);
                    }
                }
                //fallthrough intended
            case static::UPDATE_TYPE_INLINEQUERY:
            case static::UPDATE_TYPE_CHOSENINLINERESULT:
            case static::UPDATE_TYPE_CALLBACKQUERY:
            case static::UPDATE_TYPE_SHIPPINGQUERY:
            case static::UPDATE_TYPE_PRECHECKOUTQUERY:
            case static::UPDATE_TYPE_POLL:
            case static::UPDATE_TYPE_POLL_ANSWER:
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
            case 'poll':
                $handlerClass = APollHandler::class;
                break;
            case 'pollAnswer':
                $handlerClass = APollAnswerHandler::class;
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

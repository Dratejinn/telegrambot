<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Bot;
use Telegram\API\Method\GetChatAdministrators;
use Telegram\API\Method\SendMessage;

/**
 * Class Chat
 * @package Telegram\API\Type
 * @property float|int $id
 * @property string $type
 * @property null|string $title
 * @property null|string $username
 * @property null|string $firstName
 * @property null|string $lastName
 * @property null|\Telegram\API\Type\ChatPhoto $photo
 * @property null|string $bio
 * @property null|string $description
 * @property null|string $inviteLink
 * @property null|\Telegram\API\Type\Message $pinnedMessage
 * @property null|\Telegram\API\Type\ChatPermissions $permissions
 * @property null|int $slowModeDelay
 * @property null|int $messageAutoDeleteTime
 * @property null|string $stickerSetName
 * @property null|bool $canSetStickerSet
 * @property null|float|int $linkedChatId
 * @property null|\Telegram\API\Type\ChatLocation $location
 */
class Chat extends ABaseObject {

    const TYPE_PRIVATE = 'private';
    const TYPE_GROUP = 'group';
    const TYPE_SUPERGROUP = 'supergroup';
    const TYPE_CHANNEL = 'channel';

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'id'                    => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => FALSE,    'external' => 'id'],
            'type'                  => ['type' => ABaseObject::T_STRING,                            'optional' => FALSE,    'external' => 'type'],
            'title'                 => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'title'],
            'username'              => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'username'],
            'firstName'             => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'first_name'],
            'lastName'              => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'last_name'],
            'photo'                 => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'photo',              'class' => ChatPhoto::class],
            'bio'                   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'bio'],
            'description'           => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'description'],
            'inviteLink'            => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'invite_link'],
            'pinnedMessage'         => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'pinned_message',     'class' => Message::class],
            'permissions'           => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'permissions',        'class' => ChatPermissions::class],
            'slowModeDelay'         => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'slow_mode_delay'],
            'messageAutoDeleteTime' => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'message_auto_delete_time'],
            'stickerSetName'        => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'sticker_set_name'],
            'canSetStickerSet'      => ['type' => ABaseObject::T_BOOL,                              'optional' => TRUE,     'external' => 'can_set_sticker_set'],
            'linkedChatId'          => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => TRUE,     'external' => 'linked_chat_id'],
            'location'              => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'location',           'class' => ChatLocation::class]
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    /**
     * Create a chat instance
     * @param float $id
     * @param string $type
     * @return self
     */
    final public static function Create(float $id, string $type) : self {
        $chat = new self;
        $chat->id = $id;
        $chat->type = $type;
        return $chat;
    }

    /**
     * @param \Telegram\API\Bot $bot
     * @return \Telegram\API\Type\ChatMember[];
     */
    final public function getChatAdmins(Bot $bot) : array {
        $getChatAdministrators = new GetChatAdministrators;
        $getChatAdministrators->chatId = $this->id;
        $result = $getChatAdministrators->call($bot);
        if ($result === FALSE || $result === NULL) {
            return [];
        }
        return $result;
    }

    /**
     * Used to send a text message to the chat
     * @param \Telegram\API\Bot $bot
     * @param string $message
     * @return \Telegram\API\Type\Message
     */
    final public function sendTextMessage(Bot $bot, string $message) {
        $sendMessage = new SendMessage;
        $sendMessage->text = $message;
        return $this->sendMessage($bot, $sendMessage);
    }

    /**
     * Used to send a sendMessage with given bot
     * @param \Telegram\API\Bot $bot
     * @param \Telegram\API\Method\SendMessage $message
     * @return \Telegram\API\Type\Message
     */
    final public function sendMessage(Bot $bot, SendMessage $message) {
        $message->chatId = $this->id;
        return $message->call($bot);
    }
}

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
 * @property null|bool $allAdmin
 * @property null|\Telegram\API\Type\ChatPhoto $photo
 * @property null|string $description
 * @property null|string $inviteLink
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
        $datamodel = [
            'id'            => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => FALSE,    'external' => 'id'],
            'type'          => ['type' => ABaseObject::T_STRING,                            'optional' => FALSE,    'external' => 'type'],
            'title'         => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'title'],
            'username'      => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'username'],
            'firstName'     => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'first_name'],
            'lastName'      => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'last_name'],
            'allAdmin'      => ['type' => ABaseObject::T_BOOL,                              'optional' => TRUE,     'external' => 'all_members_are_administrators'],
            'photo'         => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'photo', 'class' => ChatPhoto::class],
            'description'   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'description'],
            'inviteLink'    => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'invite_link']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Create a chat instance
     * @param float $id
     * @param string $type
     */
    final public static function Create(float $id, string $type) {
        $chat = new self;
        $chat->id = $id;
        $chat->type = $type;
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

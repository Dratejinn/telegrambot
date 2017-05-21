<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Message extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'message_id'],
            'from'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'from',                       'class' => User::class],
            'date'                  => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'date'],
            'chat'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'chat',                       'class' => Chat::class],
            'forwardFrom'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'forward_from',               'class' => User::class],
            'forwardFromMessageId'  => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'forward_from_message_id'],
            'forwardDate'           => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'forward_date'],
            'replyToMessage'        => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'reply_to_message',           'class' => Message::class],
            'editDate'              => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'edit_date'],
            'text'                  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'text'],

            'entities'              => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'entities'],
            'audio'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'audio',                      'class' => Audio::class],
            'document'              => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'document',                   'class' => Document::class],
            'game'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'game',                       'class' => Game::class],
            'photo'                 => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'photo'],
            'sticker'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'sticker',                    'class' => Sticker::class],
            'video'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'video',                      'class' => Video::class],
            'voice'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'voice',                      'class' => Voice::class],
            'videoNote'             => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'video_note',                 'class' => VideoNote::class],
            'caption'               => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'caption'],
            'contact'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'contact',                    'class' => Contact::class],
            'location'              => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'location',                   'class' => Location::class],
            'venue'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'venue',                      'class' => Venue::class],

            'newChatMember'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'new_chat_member',            'class' => User::class],
            'newChatMembers'        => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'new_chat_members'],
            'leftChatMember'        => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'left_chat_member',           'class' => User::class],
            'newChatTitle'          => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'new_chat_title'],
            'newChatPhoto'          => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'new_chat_photo'],
            'deleteChatPhoto'       => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'delete_chat_photo'],
            'groupChatCreated'      => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'group_chat_created'],
            'superGroupChatCreated' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'supergroup_chat_created'],
            'channelChatCreated'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'channel_chat_created'],
            'migrateToChatId'       => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'migrate_to_chat_id'],
            'migrateFromChatId'     => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'migrateFromChatId'],
            'pinnedMessage'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'pinned_message',             'class' => Message::class],
            'invoice'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'invoice',                    'class' => Invoice::class],
            'successfulPayment'     => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'successful_payment',         'class' => SuccessfulPayment::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->entities)) {
            $entities = [];
            foreach ($this->entities as $entity) {
                $entities[] = new MessageEntity($entity);
            }
            $this->entities = $entities;
        }

        if (isset($this->photo)) {
            $photoSizes = [];
            foreach ($this->photo as $photoSize) {
                $photoSizes[] = new PhotoSize($photoSize);
            }
            $this->photo = $photoSizes;
        }

        if (isset($this->newChatPhoto)) {
            $photoSizes = [];
            foreach ($this->newChatPhoto as $photoSize) {
                $photoSizes[] = new PhotoSize($photoSize);
            }
            $this->newChatPhoto = $photoSizes;
        }
        if (isset($this->newChatMembers)) {
            $chatMembers = [];
            foreach ($this->newChatMembers as $chatMember) {
                $chatMembers[] = new User($chatMember);
            }
            $this->newChatMembers = $chatMembers;
        }
    }

    public function getContentType() : string {
        if ($this->_type === NULL) {
            foreach (array_keys($this->_datamodel) as $field) {
                if ($field === 'id') {
                    continue;
                }
                if (isset($this->{$field})) {
                    $this->_type = $field;
                }
            }
        }
        return $this->_type;
    }

}

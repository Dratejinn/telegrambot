<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Chat extends ABaseObject {

    const TYPE_PRIVATE = 'private';
    const TYPE_GROUP = 'group';
    const TYPE_SUPERGROUP = 'supergroup';
    const TYPE_CHANNEL = 'channel';

    protected static $_IdProp = 'id';

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'            => ['type' => [ABaseObject::T_INT, ABaseObject::T_FLOAT],       'optional' => FALSE,    'external' => 'id'],
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

    final public static function Create(int $id, string $type) {
        $chat = new self;
        $chat->id = $id;
        $chat->type = $type;
    }
}

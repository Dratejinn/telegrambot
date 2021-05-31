<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatMemberUpdated
 * @package Telegram\API\Type
 * @property \Telegram\API\Type\Chat $chat
 * @property \Telegram\API\Type\User $from
 * @property int $date
 * @property \Telegram\API\Type\ChatMember $oldChatMember
 * @property \Telegram\API\Type\ChatMember $newChatMember
 * @property \Telegram\API\Type\ChatInviteLink $inviteLink
 */
class ChatMemberUpdated extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chat' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'chat', 'class' => Chat::class],
            'from' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'from', 'class' => User::class],
            'date' => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'date'],
            'oldChatMember' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'old_chat_member', 'class' => ChatMember::class],
            'newChatMember' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'new_chat_member', 'class' => ChatMember::class],
            'inviteLink' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'invite_link', 'class' => ChatInviteLink::class]
        ];

        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

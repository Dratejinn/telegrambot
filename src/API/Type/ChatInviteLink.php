<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatInviteLink
 * @package Telegram\API\Type
 * @property string $inviteLink
 * @property \Telegram\API\Type\User $creator
 * @property bool $isPrimary
 * @property bool $isRevoked
 * @property null|int $expireDate
 * @property null|int $memberLimit
 */
class ChatInviteLink extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'inviteLink' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invite_link'],
            'creator' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'creator', 'class' => User::class],
            'isPrimary' => ['type' => ABaseObject::T_BOOL, 'optional' => FALSE, 'external' => 'is_primary'],
            'isRevoked' => ['type' => ABaseObject::T_BOOL, 'optional' => FALSE, 'external' => 'is_revoked'],
            'expireDate' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'expire_date'],
            'memberLimit' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'member_limit']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }


}

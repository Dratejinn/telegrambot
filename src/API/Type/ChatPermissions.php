<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatPermissions
 * @package Telegram\API\Type
 * @property null|bool $canSendMessages
 * @property null|bool $canSendMediaMessages
 * @property null|bool $canSendPolls
 * @property null|bool $canSendOtherMessages
 * @property null|bool $canAddWebPagePreviews
 * @property null|bool $canChangeInfo
 * @property null|bool $canInviteUsers
 * @property null|bool $canPinMessages
 */
class ChatPermissions extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'canSendMessages' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_send_messages'],
            'canSendMediaMessages' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_send_media_messages'],
            'canSendPolls' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_send_polls'],
            'canSendOtherMessages' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_send_other_messages'],
            'canAddWebPagePreviews' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_add_web_page_previews'],
            'canChangeInfo' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_change_info'],
            'canInviteUsers' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_invite_users'],
            'canPinMessages' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'can_pin_messages']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }


}

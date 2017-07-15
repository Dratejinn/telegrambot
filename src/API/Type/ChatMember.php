<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatMember
 * @package Telegram\API\Type
 * @property \Telegram\API\Type\User $user
 * @property string $status
 * @property null|int $untilDate
 * @property null|bool $canBeEdited
 * @property null|bool $canChangeInfo
 * @property null|bool $canPostMessages
 * @property null|bool $canEditMessages
 * @property null|bool $canDeleteMessages
 * @property null|bool $canInviteUsers
 * @property null|bool $canRestrictMembers
 * @property null|bool $canPinMessages
 * @property null|bool $canPromoteMembers
 * @property null|bool $canSendMessages
 * @property null|bool $canSendMediaMessages
 * @property null|bool $canSendOtherMessages
 * @property null|bool $canAddWebPagePreviews
 */
class ChatMember extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'user'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'user',   'class' => User::class],
            'status'                => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'status'],
            'untilDate'             => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'until_date'],
            'canBeEdited'           => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_be_edited'],
            'canChangeInfo'         => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_change_info'],
            'canPostMessages'       => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_post_messages'],
            'canEditMessages'       => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_edit_messages'],
            'canDeleteMessages'     => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_delete_messages'],
            'canInviteUsers'        => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_invite_users'],
            'canRestrictMembers'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_restrict_members'],
            'canPinMessages'        => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_pin_messages'],
            'canPromoteMembers'     => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_promote_members'],
            'canSendMessages'       => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_send_messages'],
            'canSendMediaMessages'  => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_send_media_messages'],
            'canSendOtherMessages'  => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_send_other_messages'],
            'canAddWebPagePreviews' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_add_web_page_previews'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

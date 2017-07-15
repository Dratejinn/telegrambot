<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class PromoteChatMember
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $userId
 * @property null|bool $canChangeInfo
 * @property null|bool $canPostMessages
 * @property null|bool $canEditMessages
 * @property null|bool $canDeleteMessages
 * @property null|bool $canInviteUsers
 * @property null|bool $canRestrictMembers
 * @property null|bool $canPinMessages
 * @property null|bool $canPromoteMembers
 */
class PromoteChatMember extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],    'optional' => FALSE, 'external' => 'chat_id'],
            'userId'                => ['type' => ABaseObject::T_INT,                                                   'optional' => FALSE, 'external' => 'user_id'],
            'canChangeInfo'         => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_change_info'],
            'canPostMessages'       => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_post_messages'],
            'canEditMessages'       => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_edit_messages'],
            'canDeleteMessages'     => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_delete_messages'],
            'canInviteUsers'        => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_invite_users'],
            'canRestrictMembers'    => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_restrict_members'],
            'canPinMessages'        => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_pin_messages'],
            'canPromoteMembers'     => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_promote_members'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('promoteChatMember', $this);
        $arr = [];
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return $reply->result;
                }
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}

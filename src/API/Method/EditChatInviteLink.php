<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type\ChatInviteLink;
use Telegram\Exception\OutboundException;

/**
 * Class EditChatInviteLink
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property string $inviteLink
 * @property null|int $expireDate
 * @property null|int $memberLimit
 */
class EditChatInviteLink extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE, 'external' => 'chat_id'],
            'inviteLink' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invite_link'],
            'expireDate' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'expire_date'],
            'memberLimit' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'member_limit']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('editChatInviteLink', $this);

        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new ChatInviteLink($reply->result);
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }

}

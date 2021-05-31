<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type\ChatInviteLink;

/**
 * Class RevokeChatInviteLink
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property string $inviteLink
 */
class RevokeChatInviteLink extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE, 'external' => 'chat_id'],
            'inviteLink' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invite_link'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('revokeChatInviteLink', $this);

        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new ChatInviteLink($reply->result);
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

<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class GetChatMembersCount
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 */
class GetChatMembersCount extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE,    'external' => 'chat_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getChatMembersCount', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return $reply->result;
            } else {
                if (isset($reply->description)) {
                    throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new OutboundException($this, $reply, 'An unknown error has occurred!');
                }
            }
        }
        return 0;
    }
}

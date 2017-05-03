<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class GetChatMember extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'    => ['type' => ABaseObject::T_INT,   'optional' => TRUE, 'external' => 'chat_id'],
            'userId'    => ['type' => ABaseObject::T_INT,   'optional' => TRUE, 'external' => 'user_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('getChatMember', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                    return new Type\ChatMember($reply->result);
            }
        }
        return NULL;
    }
}

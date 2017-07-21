<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class GetChatMember
 * @package Telegram\API\Method
 * @property chatId float|int $chatId
 * @property userid int $userId
 */
class GetChatMember extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'    => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => TRUE, 'external' => 'chat_id'],
            'userId'    => ['type' => ABaseObject::T_INT,                           'optional' => TRUE, 'external' => 'user_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
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

<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class SetChatAdministratorCustomTitle
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $userId
 * @property string $customTitle
 */
class SetChatAdministratorCustomTitle extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $dataModel = [
            'chatId' => ['type' => [ABaseObject::T_INT, ABaseObject::T_FLOAT, ABaseObject::T_STRING], 'optional' => FALSE, 'external' => 'chat_id'],
            'userId' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'user_id'],
            'customTitle' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'custom_title']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setChatAdministratorCustomTitle', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            }
        }
        return NULL;
    }
}

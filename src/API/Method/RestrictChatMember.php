<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class RestrictChatMember
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $userId
 * @property \Telegram\API\Type\ChatPermissions $permissions
 * @property null|int $untilDate
 */
class RestrictChatMember extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],    'optional' => FALSE, 'external' => 'chat_id'],
            'userId'                => ['type' => ABaseObject::T_INT,                                                   'optional' => FALSE, 'external' => 'user_id'],
            'permissions'           => ['type' => ABaseObject::T_OBJECT,                                                'optional' => FALSE, 'external' => 'permissions', 'class' => Type\ChatPermissions::class],
            'untilDate'             => ['type' => ABaseObject::T_INT,                                                   'optional' => TRUE,  'external' => 'until_date'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('restrictChatMember', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return $reply->result;
                }
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}

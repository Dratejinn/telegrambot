<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class UnbanChatMember
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $userId
 * @property null|bool $onlyIfBanned
 */
class UnbanChatMember extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'        => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],    'optional' => FALSE,    'external' => 'chat_id'],
            'userId'        => ['type' => ABaseObject::T_INT,                                                   'optional' => FALSE,    'external' => 'user_id'],
            'onlyIfBanned'  => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,     'external' => 'only_if_banned']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('unbanChatMember', $this);
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

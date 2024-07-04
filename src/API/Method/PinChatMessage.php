<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Bot;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\Exception\OutboundException;

/**
 * Class PinChatMessage
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $messageId
 * @property null|bool $disableNotification
 */
class PinChatMessage extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],    'optional' => FALSE, 'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,                                                   'optional' => FALSE, 'external' => 'message_id'],
            'disableNotification'   => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE, 'external' => 'disable_notification']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('pinChatMessage', $this);
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

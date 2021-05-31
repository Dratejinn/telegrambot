<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Bot;
use Telegram\API\Base\Interfaces\IOutbound;

/**
 * Class UnpinChatMessage
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property null|int|float $messageId
 */
class UnpinChatMessage extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE, 'external' => 'chat_id'],
            'messageId' => ['type' => [ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => TRUE, 'external' => 'message_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('unpinChatMessage', $this);

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

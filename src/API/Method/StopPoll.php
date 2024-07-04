<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type\InlineKeyboardMarkup;
use Telegram\API\Type\Poll;
use Telegram\Exception\OutboundException;

/**
 * Class StopPoll
 * @package Telegram\API\Method
 * @property int|float $chatId
 * @property int $messageId
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class StopPoll extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $dataModel = [
            'chatId' => ['type' => [ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE, 'external' => 'chat_id'],
            'messageId' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'message_id'],
            'replyMarkup' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'reply_markup', 'class' => InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('stopPoll', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result === TRUE) {
                    return TRUE;
                } else {
                    return new Poll($reply->result);
                }
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}

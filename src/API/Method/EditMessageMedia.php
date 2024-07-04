<?php

declare(strict_types = 1);


namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\AInputMedia;
use Telegram\API\Bot;
use Telegram\API\Type\InlineKeyboardMarkup;
use Telegram\Exception\OutboundException;

/**
 * Class EditMessageMedia
 * @package Telegram\API\Method
 * @property int|float $chatId
 * @property null|int $messageId
 * @property null|string $inlineMessageId
 * @property \Telegram\API\Base\Abstracts\AInputMedia $media
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class EditMessageMedia extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {

        $datamodel = [
            'chatId' => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT], 'optional' => TRUE, 'external' => 'chat_id'],
            'messageId' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'message_id'],
            'inlineMessageId' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'inline_message_id'],
            'media' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'media', 'class' => AInputMedia::class],
            'replyMarkup' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external ' => 'reply_markup', 'class' => InlineKeyboardMarkup::class]
        ];

        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('editMessageMedia', $this);
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

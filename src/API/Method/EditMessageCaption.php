<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type;
use Telegram\Exception\OutboundException;

/**
 * Class EditMessageText
 * @package Telegram\API\Method
 * @property null|float|int $chatId
 * @property null|int $messageId
 * @property null|string $inlineMessageId
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class EditMessageCaption extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => TRUE,     'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'message_id'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'inline_message_id'],
            'caption'               => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'caption'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'       => ['type' => ABaseObject::T_ARRAY,                         'optional' => TRUE,     'external' => 'caption_entities'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,                        'optional' => TRUE,     'external' => 'reply_markup',       'class' => Type\InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('editMessageCaption', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result === TRUE) {
                    return TRUE;
                } else {
                    return new Type\Message($reply->result);
                }
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}

<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type;

/**
 * Class EditMessageText
 * @package Telegram\API\Method
 * @property null|float|int $chatId
 * @property null|int $messageId
 * @property string $text
 * @property null|string $parseMode
 * @property null|bool $disableWebPagePreview
 * @property null|string $inlineMessageId
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class EditMessageText extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => TRUE,     'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'message_id'],
            'text'                  => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE,    'external' => 'text'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'parse_mode'],
            'disableWebPagePreview' => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,     'external' => 'disable_web_page_preview'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'inline_message_id'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,                        'optional' => TRUE,     'external' => 'reply_markup',       'class' => Type\InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('editMessageText', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result === TRUE) {
                    return TRUE;
                } else {
                    return new Type\Message($reply->result);
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

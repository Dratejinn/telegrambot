<?php

declare(strict_types=1);

namespace Telegram\API\Games\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Type\InlineKeyboardMarkup;

/**
 * Class SendGame
 * @package Telegram\API\Games\Method
 * @property float|int $chatId
 * @property string $gameShortName
 * @property null|bool $disableNotification
 * @property null|int $replyToMessageId
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class SendGame extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => FALSE,    'external' => 'chat_id'],
            'gameShortName'         => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE,    'external' => 'game_short_name'],
            'disableNotification'   => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,     'external' => 'disable_notification'],
            'replyToMessageId'      => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'reply_to_message_id'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,                        'optional' => TRUE,     'external' => 'reply_markup',           'class' => InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

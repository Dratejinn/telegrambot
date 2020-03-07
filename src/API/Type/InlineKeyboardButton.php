<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Games\Type\CallbackGame;

/**
 * Class InlineKeyboardButton
 * @package Telegram\API\Type
 * @property string $text
 * @property null|string $url
 * @property null|\Telegram\API\Type\LoginUrl $loginUrl
 * @property null|string $callbackData
 * @property null|string $switchInlineQuery
 * @property null|string $switchInlineQueryCurrentChat
 * @property null|\Telegram\API\Games\Type\CallbackGame $callbackGame
 * @property null|bool $pay
 */
class InlineKeyboardButton extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'text'                          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'text'],
            'url'                           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'url'],
            'loginUrl'                      => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,    'external' => 'login_url',                          'class' => LoginUrl::class],
            'callbackData'                  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'callback_data'],
            'switchInlineQuery'             => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'switch_inline_query'],
            'switchInlineQueryCurrentChat'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'switch_inline_query_current_chat'],
            'callbackGame'                  => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,    'external' => 'callback_game',                      'class' => CallbackGame::class],
            'pay'                           => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,    'external' => 'pay']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class InlineKeyboardButton extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
        'text'                  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'text'],
        'url'                   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'url'],
        'callbackData'          => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'callback_data'],
        'switchInlineQuery'     => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'switch_inline_query'],
        'switchQueryCurrChat'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'switch_inline_query_current_chat'],
        'callbackGame'          => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,    'external' => 'callback_game',                      'class' => CallbackGame::class],
        'pay'                   => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,    'external' => 'pay']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

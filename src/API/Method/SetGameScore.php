<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Type\InlineKeyboardMarkup;

class SetGameScore extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'                => ['type' => ABaseObject::T_INT,       'optional' => FALSE, 'external' => 'user_id'],
            'score'                 => ['type' => ABaseObject::T_INT,       'optional' => FALSE, 'external' => 'score'],
            'force'                 => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,  'external' => 'force'],
            'disableEditMessage'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,  'external' => 'disable_edit_message'],
            'chatId'                => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'message_id'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,  'external' => 'inline_message_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

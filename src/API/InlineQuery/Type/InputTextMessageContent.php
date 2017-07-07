<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class InputTextMessageContent extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'messageText'           => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'message_text'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'parse_mode'],
            'disableWebPagePreview' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'disable_web_page_preview'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

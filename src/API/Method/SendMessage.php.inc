<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Bot;

class SendMessage extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'text'                  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'text'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'parse_mode'],
            'disableWebPagePreview' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'disable_web_page_preview'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

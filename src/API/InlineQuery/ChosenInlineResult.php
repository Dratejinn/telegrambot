<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Type;

class ChosenInlineResult extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'resultId'          => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'result_id'],
            'from'              => ['type' => ABaseObject::T_OBJECT,   'optional' => FALSE,    'external' => 'from',                'class' => Type\User::class],
            'location'          => ['type' => ABaseObject::T_OBJECT,   'optional' => TRUE,     'external' => 'location',            'class' => Type\Location::class],
            'inlineMessageId'   => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'inline_message_id'],
            'query'             => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'query'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

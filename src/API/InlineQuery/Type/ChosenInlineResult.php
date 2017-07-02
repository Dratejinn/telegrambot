<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API;

class ChosenInlineResult extends ABaseObject {

    protected static $_IdProp = 'resultId';

    public static function GetDatamodel() : array {
        $datamodel = [
            'resultId'          => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'result_id'],
            'from'              => ['type' => ABaseObject::T_OBJECT,   'optional' => FALSE,    'external' => 'from',                'class' => API\Type\User::class],
            'location'          => ['type' => ABaseObject::T_OBJECT,   'optional' => TRUE,     'external' => 'location',            'class' => API\Type\Location::class],
            'inlineMessageId'   => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'inline_message_id'],
            'query'             => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'query'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

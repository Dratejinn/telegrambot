<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\ABaseObject;

class AnswerInlineQuery extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'inlineQueryId'     => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'inline_query_id'],
            'results'           => ['type' => ABaseObject::T_ARRAY,     'optional' => FALSE,    'external' => 'results'],
            'cacheTime'         => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'cache_time'],
            'isPersonal'        => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'is_personal'],
            'nextOffset'        => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'next_offset'],
            'switchPmText'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'switch_pm_text'],
            'switchPmParameter' => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'switch_pm_parameter']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

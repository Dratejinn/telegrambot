<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type;

class InlineQuery extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'        => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'id'],
            'from'      => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'from',       'class' => Type\User::class],
            'location'  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'location',   'class' => Type\Location::class],
            'query'     => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'query'],
            'offset'    => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'offset'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

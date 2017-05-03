<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\ABaseObject;

class InputLocationMessageContent extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'    => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'latitude'],
            'longitude'   => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'longitude'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

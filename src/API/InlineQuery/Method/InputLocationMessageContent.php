<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

class InputLocationMessageContent extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'    => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'latitude'],
            'longitude'   => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'longitude'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

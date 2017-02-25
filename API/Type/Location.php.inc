<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Location extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'longitude'    => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,  'external' => 'longitude'],
            'latitude'     => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,  'external' => 'latitude'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

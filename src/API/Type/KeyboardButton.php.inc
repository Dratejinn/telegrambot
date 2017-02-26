<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class KeyboardButton extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
        'text'              => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,   'external' => 'text'],
        'requestContact'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,    'external' => 'request_contact'],
        'requestLocation'   => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,    'external' => 'request_location'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

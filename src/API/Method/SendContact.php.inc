<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

class SendContact extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'phoneNumber'   => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'phone_number'],
            'firstName'     => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'first_name'],
            'lastName'      => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'last_name'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

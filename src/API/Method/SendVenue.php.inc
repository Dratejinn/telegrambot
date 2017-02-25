<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;

class SendVenue extends SendLocation {

    public static function GetDatamodel() : array {
        $datamodel = [
            'title'         => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'title'],
            'address'       => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'address'],
            'foursquareId'  => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'foursquare_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

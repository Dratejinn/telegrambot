<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class ShippingAddress extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'countryCode'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'country_code'],
            'state'         => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'state'],
            'city'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'city'],
            'streetLine1'  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'street_line1'],
            'streetLine2'  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'street_line2'],
            'postCode'     => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'post_code'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

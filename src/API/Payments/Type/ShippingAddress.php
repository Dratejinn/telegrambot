<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ShippingAddress
 * @package Telegram\API\Payments\Type
 * @property string $countryCode
 * @property string $state
 * @property string $city
 * @property string $streetLine1
 * @property string $streetLine2
 * @property string $postCode
 */
class ShippingAddress extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'countryCode'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'country_code'],
            'state'         => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'state'],
            'city'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'city'],
            'streetLine1'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'street_line1'],
            'streetLine2'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'street_line2'],
            'postCode'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'post_code'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

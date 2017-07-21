<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class OrderInfo
 * @package Telegram\API\Payments\Type
 * @property null|string $name
 * @property null|string $phoneNumber
 * @property null|string $email
 * @property null|\Telegram\API\Payments\Type\ShippingAddress $shippingAddress
 */
class OrderInfo extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'name'              => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'name'],
            'phoneNumber'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'phone_number'],
            'email'             => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'email'],
            'shippingAddress'   => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'shipping_address', 'class' => ShippingAddress::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

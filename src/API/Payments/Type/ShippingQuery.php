<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class ShippingQuery extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'id'],
            'from'              => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'from',             'class' => User::class],
            'invoicePayload'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invoice_payload'],
            'shippingAddress'   => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'shipping_address', 'class' => ShippingAddress::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class SuccessfulPayment extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'currency'                   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'currency'],
            'totalAmount'                => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'total_amount'],
            'invoicePayload'             => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invoice_payload'],
            'shippingOptionId'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'shipping_option_id'],
            'orderInfo'                  => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'order_info', 'class' => OrderInfo::class],
            'telegramPaymentChargeId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'telegram_payment_charge_id'],
            'providerPaymentChargeId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'provider_payment_charge_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

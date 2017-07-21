<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\User;

/**
 * Class PreCheckoutQuery
 * @package Telegram\API\Payments\Type
 * @property string $id
 * @property \Telegram\API\Type\User $from
 * @property string $currency
 * @property int $totalAmount
 * @property string $invoicePayload
 * @property null|string $shippingOptionId
 * @property null|\Telegram\API\Payments\Type\OrderInfo $orderInfo
 */
class PreCheckoutQuery extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'id'],
            'from'                  => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'from',             'class' => User::class],
            'currency'              => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'currency'],
            'totalAmount'           => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'total_amount'],
            'invoicePayload'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'invoice_payload'],
            'shippingOptionId'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'shipping_option_id'],
            'orderInfo'             => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'order_info',        'class' => OrderInfo::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ShippingOption
 * @package Telegram\API\Payments\Type
 * @property string $id
 * @property string $title
 * @property \Telegram\API\Payments\Type\LabeledPrice[] $prices
 */
class ShippingOption extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'id'],
            'title'     => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'title'],
            'prices'    => ['type' => ABaseObject::T_ARRAY,  'optional' => FALSE, 'external' => 'prices'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

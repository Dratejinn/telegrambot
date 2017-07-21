<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Invoice
 * @package Telegram\API\Payments\Type
 * @property string $title
 * @property string $description
 * @property string $startParameter
 * @property string $currency
 * @property int $totalAmount
 */
class Invoice extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'title'             => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'title'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'description'],
            'startParameter'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'start_parameter'],
            'currency'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'currency'],
            'totalAmount'       => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'total_amount'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

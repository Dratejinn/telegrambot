<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class LabeledPrice
 * @package Telegram\API\Payments\Type
 * @property string $label
 * @property int $amount
 */
class LabeledPrice extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'label'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,  'external' => 'label'],
            'amount'   => ['type' => ABaseObject::T_INT,    'optional' => FALSE,  'external' => 'amount'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

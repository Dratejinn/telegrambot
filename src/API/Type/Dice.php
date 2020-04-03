<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Dice
 * @package Telegram\API\Type
 *
 * @property int $value
 */
class Dice extends ABaseObject {
    public static function GetDatamodel() : array {
        $datamodel = [
            'value'   => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'value']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

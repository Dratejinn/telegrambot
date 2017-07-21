<?php

declare(strict_types=1);

namespace Telegram\API\Stickers\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class MaskPosition
 * @package Telegram\API\Stickers\Type
 * @property string $point
 * @property float $xShift
 * @property float $yShift
 * @property float $zoom
 */
class MaskPosition extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'point'     => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'point'],
            'xShift'    => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE, 'external' => 'x_shift'],
            'yShift'    => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE, 'external' => 'y_shift'],
            'zoom'      => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE, 'external' => 'zoom']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

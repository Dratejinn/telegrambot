<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Location
 * @package Telegram\API\Type
 * @property float $longitude
 * @property float $latitude
 */
class Location extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'longitude'    => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,  'external' => 'longitude'],
            'latitude'     => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,  'external' => 'latitude'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

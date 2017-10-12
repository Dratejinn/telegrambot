<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

/**
 * Class SendLocation
 * @package Telegram\API\Method
 * @property float $latitude
 * @property float $longitude
 * @property null|int $livePeriod
 */
class SendLocation extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'    => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'latitude'],
            'longitude'   => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'longitude'],
            'livePeriod'  => ['type' => ABaseObject::T_INT,     'optional' => TRUE,     'external' => 'live_period']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

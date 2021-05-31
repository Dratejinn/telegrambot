<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Location
 * @package Telegram\API\Type
 * @property float $longitude
 * @property float $latitude
 * @property null|float $horizontalAccuracy
 * @property null|int $livePeriod
 * @property null|int $heading
 * @property null|int $propximityAlertRadius
 */
class Location extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'longitude'             => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,    'external' => 'longitude'],
            'latitude'              => ['type' => ABaseObject::T_FLOAT, 'optional' => FALSE,    'external' => 'latitude'],
            'horizontalAccuracy'    => ['type' => ABaseObject::T_FLOAT, 'optional' => TRUE,     'external' => 'horizontal_accuracy'],
            'livePeriod'            => ['type' => ABaseObject::T_INT,   'optional' => TRUE,     'external' => 'live_period'],
            'heading'               => ['type' => ABaseObject::T_INT,   'optional' => TRUE,     'external' => 'heading'],
            'proximityAlertRadius'  => ['type' => ABaseObject::T_INT,   'optional' => TRUE,     'external' => 'proximity_alert_radius']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

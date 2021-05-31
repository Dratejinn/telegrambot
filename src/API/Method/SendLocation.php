<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

/**
 * Class SendLocation
 * @package Telegram\API\Method
 * @property float $latitude
 * @property float $longitude
 * @property null|float $horizontalAccuracy
 * @property null|int $livePeriod
 * @property null|int $heading
 * @property null|int $proximityAlertRadius
 */
class SendLocation extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'              => ['type' => ABaseObject::T_FLOAT,     'optional' => FALSE,   'external' => 'latitude'],
            'longitude'             => ['type' => ABaseObject::T_FLOAT,     'optional' => FALSE,   'external' => 'longitude'],
            'horizontalAccuracy'    => ['type' => ABaseObject::T_FLOAT,     'optional' => TRUE,    'external' => 'horizontal_accuracy'],
            'livePeriod'            => ['type' => ABaseObject::T_INT,       'optional' => TRUE,    'external' => 'live_period'],
            'heading'               => ['type' => ABaseObject::T_INT,       'optional' => TRUE,    'external' => 'heading'],
            'proximityAlertRadius'  => ['type' => ABaseObject::T_INT,       'optional' => TRUE,    'external' => 'proximity_alert_radius']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

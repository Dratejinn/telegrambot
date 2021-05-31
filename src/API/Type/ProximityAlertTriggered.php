<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ProximityAlertTriggered
 * @package Telegram\API\Type
 * @property \Telegram\API\Type\User $traveler
 * @property \Telegram\API\Type\User $watcher
 * @property int $distance
 */
class ProximityAlertTriggered extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'traveler' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'traveler', 'class' => User::class],
            'watcher' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'watcher', 'class' => User::class],
            'distance' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'distance']
        ];

        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

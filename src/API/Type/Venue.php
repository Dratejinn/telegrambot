<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Venue
 * @package Telegram\API\Type
 * @property \Telegram\API\Type\Location $location
 * @property string $title
 * @property string $address
 * @property null|string $foursquareId
 * @property null|string $foursquareType
 * @property null|string $googlePlaceId
 * @property null|string $googlePlaceType
 */
class Venue extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'location'          => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,  'external' => 'location', 'class' => Location::class],
            'title'             => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'title'],
            'address'           => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'address'],
            'foursquareId'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'foursquare_id'],
            'foursquareType'    => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'foursquare_type'],
            'googlePlaceId'     => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'google_place_id'],
            'googlePlaceType'   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'google_place_type']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

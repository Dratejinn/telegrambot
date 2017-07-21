<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class SendVenue
 * @package Telegram\API\Method
 * @property string $title
 * @property string $address
 * @property null|string $foursquareId
 */
class SendVenue extends SendLocation {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'title'         => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'title'],
            'address'       => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'address'],
            'foursquareId'  => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'foursquare_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

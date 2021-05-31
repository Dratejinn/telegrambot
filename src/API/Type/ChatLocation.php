<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatLocation
 * @package Telegram\API\Type
 * @property \Telegram\API\Type\Location $location
 * @property string $address
 */
class ChatLocation extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'location' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'location', 'class' => Location::class],
            'address' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'address']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }


}

<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class InputLocationMessageContent
 * @package Telegram\API\InlineQuery\Type
 * @property float $latitude
 * @property float $longitude
 */
class InputLocationMessageContent extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'    => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'latitude'],
            'longitude'   => ['type' => ABaseObject::T_FLOAT,   'optional' => FALSE,    'external' => 'longitude'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

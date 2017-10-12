<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class InputLocationMessageContent
 * @package Telegram\API\InlineQuery\Type
 * @property float $latitude
 * @property float $longitude
 * @property null|int $livePeriod
 */
class InputLocationMessageContent extends ABaseObject {

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

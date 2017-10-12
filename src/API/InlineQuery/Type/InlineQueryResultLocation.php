<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultLocation
 * @package Telegram\API\InlineQuery\Type
 * @property float $latitude
 * @property float $longitude
 * @property null|string $thumbUrl
 * @property null|int $thumbWidth
 * @property null|int $thumbHeight
 * @property null|int $livePeriod
 */
class InlineQueryResultLocation extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'      => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE,   'external' => 'latitude'],
            'longitude'     => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE,   'external' => 'longitude'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'thumb_url'],
            'thumbWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_width'],
            'thumbHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_height'],
            'livePeriod'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'live_period']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'location';
    }
}

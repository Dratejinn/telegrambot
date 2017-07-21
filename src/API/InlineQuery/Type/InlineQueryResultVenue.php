<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class InlineQueryResultVenue
 * @package Telegram\API\InlineQuery\Type
 * @property string $title
 * @property string $address
 * @property null|string $foursquareId
 */
class InlineQueryResultVenue extends InlineQueryResultLocation {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'title'         => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'title'],
            'address'       => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'address'],
            'foursquareId'  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'foursquare_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'venue';
    }
}

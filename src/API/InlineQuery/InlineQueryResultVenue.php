<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\ABaseObject;

class InlineQueryResultVenue extends InlineQueryResultLocation {

    public static function GetDatamodel() : array {
        $datamodel = [
            'title'         => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'title'],
            'address'       => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,  'external' => 'address'],
            'foursquareId'  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,   'external' => 'foursquare_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'venue';
    }
}

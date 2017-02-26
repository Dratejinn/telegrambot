<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultLocation extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'latitude'      => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE,   'external' => 'latitude'],
            'longitude'     => ['type' => ABaseObject::T_FLOAT,  'optional' => FALSE,   'external' => 'longitude'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'thumb_url'],
            'thumbWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_width'],
            'thumbHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_height']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'location';
    }
}

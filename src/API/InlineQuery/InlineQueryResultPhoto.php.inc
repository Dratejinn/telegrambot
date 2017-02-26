<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult}

class InlineQueryResultPhoto extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'photoUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'photo_url'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'photoWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_width'],
            'photoHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_height'],
            'description'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'description'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'photo';
    }
}

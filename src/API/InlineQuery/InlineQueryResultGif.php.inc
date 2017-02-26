<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult}

class InlineQueryResultGif extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'gifUrl'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'gif_url'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'gifWidth'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'gif_width'],
            'gifHeight'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'gif_height'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'gif';
    }
}

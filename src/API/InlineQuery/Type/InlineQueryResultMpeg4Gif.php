<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultMpeg4Gif extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'mpeg4Url'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'mpeg4_url'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'mpeg4Width'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_width'],
            'mpeg4Height'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_height'],
            'mpeg4Duration' => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_duration'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'mpeg4_gif';
    }
}

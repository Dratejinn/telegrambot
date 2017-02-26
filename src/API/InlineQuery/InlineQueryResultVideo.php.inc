<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultVideo extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'videoUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'video_url'],
            'mimeType'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'mime_type'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'videoWidth'    => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_width'],
            'videoHeight'   => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_height'],
            'videoDuration' => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_duration'],
            'description'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'description'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

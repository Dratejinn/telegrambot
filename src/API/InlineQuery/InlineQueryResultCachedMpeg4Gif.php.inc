<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultCachedMpeg4Gif extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'mpeg4FileId'   => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'mpeg4_file_id'],
            'caption'       => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'mpeg4_gif';
    }
}

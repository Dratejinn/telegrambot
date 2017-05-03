<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultCachedGif extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'gifFileId'     => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'gif_file_id'],
            'caption'       => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'gif';
    }
}

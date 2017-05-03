<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultCachedDocument extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'documentFileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'document_file_id'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'description'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'document';
    }
}

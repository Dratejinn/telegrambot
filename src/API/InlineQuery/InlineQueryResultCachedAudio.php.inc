<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultCachedAudio extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $parentModel = parent::GetDatamodel();
        unset($parentModel['title']);
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'audioFileId'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'audio_file_id'],
        ];
        return array_merge($parentModel, $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'audio';
    }
}

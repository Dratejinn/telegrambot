<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultAudio extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'audioUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'audio_url'],
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'performer'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'performer'],
            'audioDuration'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'audio_duration'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'audio';
    }
}

<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultAudio
 * @package Telegram\API\InlineQuery\Type
 * @property string $audioUrl
 * @property null|string $caption
 * @property null|string $performer
 * @property null|int $audioDuration
 */
class InlineQueryResultAudio extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'audioUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'audio_url'],
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'performer'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'performer'],
            'audioDuration'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'audio_duration'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'audio';
    }
}

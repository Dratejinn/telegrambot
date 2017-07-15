<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedVoice
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $caption
 * @property string $voiceFileId
 */
class InlineQueryResultCachedVoice extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'voiceFileId'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'voice_file_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'voice';
    }
}

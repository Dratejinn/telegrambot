<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultVoice
 * @package Telegram\API\InlineQuery\Type
 * @property string $voiceUrl
 * @property null|string $caption
 * @property null|string $performer
 * @property null|int $voiceDuration
 */
class InlineQueryResultVoice extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'voiceUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'voice_url'],
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'performer'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'performer'],
            'voiceDuration'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'voice_duration'],
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

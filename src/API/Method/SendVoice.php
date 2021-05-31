<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

/**
 * Class SendVoice
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $voice
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property null|int $duration
 */
class SendVoice extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'voice'             => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'voice',      'class' => InputFile::class],
            'caption'           => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,                             'optional' => TRUE,     'external' => 'caption_entities'],
            'duration'          => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

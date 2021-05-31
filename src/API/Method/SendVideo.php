<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

/**
 * Class SendVideo
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $video
 * @property null|int $duration
 * @property null|int $width
 * @property null|int $height
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property null|bool $supportsStreaming
 */
class SendVideo extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'video'             => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'video',      'class' => InputFile::class],
            'duration'          => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration'],
            'width'             => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'width'],
            'height'            => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'height'],
            'caption'           => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,                             'optional' => TRUE,     'external' => 'caption_entities'],
            'supportsStreaming' => ['type' => ABaseObject::T_BOOL,                              'optional' => TRUE,     'external' => 'supports_streaming']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

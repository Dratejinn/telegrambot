<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

/**
 * Class SendAudio
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $audio
 * @property null|int $duration
 * @property null|string $performer
 * @property null|string $title
 * @property null|string $caption
 */
class SendAudio extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'audio'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'audio',      'class' => InputFile::class],
            'duration'  => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration'],
            'performer' => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'performer'],
            'title'     => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'title'],
            'caption'   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

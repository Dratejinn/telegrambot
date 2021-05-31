<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

/**
 * Class SendPhoto
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $photo
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class SendPhoto extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'photo'             => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'photo',      'class' => InputFile::class],
            'caption'           => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,                             'optional' => TRUE,     'external' => 'caption_entities']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

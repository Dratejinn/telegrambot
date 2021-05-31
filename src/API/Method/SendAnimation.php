<?php

declare(strict_types=1);


namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\ASend;
use Telegram\API\Base\InputFile;

/**
 * Class SendAnimation
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $animation
 * @property null|int $duration
 * @property null|int $width
 * @property null|int $height
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class SendAnimation extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'animation' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => FALSE, 'external' => 'animation', 'class' => InputFile::class],
            'duration' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external'  => 'duration'],
            'width' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'width'],
            'height' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'height'],
            'thumb' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class],
            'caption' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'caption'],
            'parseMode' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'parse_mode'],
            'captionEntities' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'caption_entities']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

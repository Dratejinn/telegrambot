<?php

declare(strict_types = 1);

namespace Telegram\API\Stickers\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\PhotoSize;

/**
 * Class Sticker
 * @package Telegram\API\Stickers\Type
 * @property string $fileId
 * @property string $fileUniqueId
 * @property int $width
 * @property int $height
 * @property bool $isAnimated
 * @property null|\Telegram\API\Type\PhotoSize $thumb
 * @property null|string $emoji
 * @property null|string $setName
 * @property null|\Telegram\API\Stickers\Type\MaskPosition $maskPosition
 * @property null|int $fileSize
 */
class Sticker extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'file_id'],
            'fileUniqueId'  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'file_unique_id'],
            'width'         => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'width'],
            'height'        => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'height'],
            'isAnimated'    => ['type' => ABaseObject::T_BOOL,   'optional' => FALSE, 'external' => 'is_animated'],
            'thumb'         => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'thumb',            'class' => PhotoSize::class],
            'emoji'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'emoji'],
            'setName'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'set_name'],
            'maskPosition'  => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'mask_position',    'class' => MaskPosition::class],
            'fileSize'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'file_size']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}

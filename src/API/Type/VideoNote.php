<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class VideoNote
 * @package Telegram\API\Type
 * @property string $fileId
 * @property string $fileUniqueId
 * @property int $length
 * @property int $duration
 * @property null|\Telegram\API\Type\PhotoSize $thumb
 * @property null|int $fileSize
 */
class VideoNote extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_id'],
            'fileUniqueId'  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_unique_id'],
            'length'        => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'length'],
            'duration'      => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'duration'],
            'thumb'         => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,     'external' => 'thumb',     'class' => PhotoSize::class],
            'fileSize'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'file_size']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
